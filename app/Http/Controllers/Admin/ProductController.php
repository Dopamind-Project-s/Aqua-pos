<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $status = (string) $request->string('status', 'all');
        $categoryId = (int) $request->integer('category_id');

        $products = Product::query()
            ->with(['category'])
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($nested) use ($search): void {
                    $nested->where('name', 'like', "%{$search}%")
                        ->orWhere('name_ar', 'like', "%{$search}%")
                        ->orWhere('name_en', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->when($status === 'active', fn ($query) => $query->where('is_active', true))
            ->when($status === 'inactive', fn ($query) => $query->where('is_active', false))
            ->when($categoryId > 0, fn ($query) => $query->where('category_id', $categoryId))
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::query()->whereNull('deleted_at')->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'search', 'status', 'categoryId'));
    }

    public function create(): View
    {
        $categories = Category::query()->whereNull('deleted_at')->orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        unset($data['gallery_images'], $data['gallery_alt'], $data['existing_alt'], $data['existing_sort'], $data['delete_images']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::query()->create($data);

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $file) {
                $product->images()->create([
                    'image' => $file->store('products/gallery', 'public'),
                    'alt' => $request->input("gallery_alt.{$index}"),
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'images']);

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::query()->whereNull('deleted_at')->orderBy('name')->get();
        $product->load(['images' => fn ($query) => $query->orderBy('sort_order')->orderBy('id')]);

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        unset($data['gallery_images'], $data['gallery_alt'], $data['existing_alt'], $data['existing_sort'], $data['delete_images']);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        $deleteIds = collect((array) $request->input('delete_images', []))
            ->filter()
            ->map(fn ($id) => (int) $id)
            ->all();

        if ($deleteIds !== []) {
            $imagesToDelete = $product->images()->whereIn('id', $deleteIds)->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->image);
                $image->delete();
            }
        }

        $product->images()->get()->each(function ($image) use ($request): void {
            $image->update([
                'alt' => $request->input("existing_alt.{$image->id}"),
                'sort_order' => (int) $request->input("existing_sort.{$image->id}", $image->sort_order),
            ]);
        });

        if ($request->hasFile('gallery_images')) {
            $nextSort = (int) $product->images()->max('sort_order') + 1;
            foreach ($request->file('gallery_images') as $index => $file) {
                $product->images()->create([
                    'image' => $file->store('products/gallery', 'public'),
                    'alt' => $request->input("gallery_alt.{$index}"),
                    'sort_order' => $nextSort + $index,
                ]);
            }
        }

        return redirect()->route('admin.products.edit', $product)->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product soft deleted successfully.');
    }
}
