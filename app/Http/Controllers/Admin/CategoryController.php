<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BulkCategoryActionRequest;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('search'));
        $status = (string) $request->string('status', 'all');

        $categories = Category::query()
            ->withTrashed()
            ->withCount(['products' => fn (Builder $query) => $query->whereNull('deleted_at')])
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $nested) use ($search): void {
                    $nested->where('name', 'like', "%{$search}%")
                        ->orWhere('name_ar', 'like', "%{$search}%")
                        ->orWhere('name_en', 'like', "%{$search}%");
                });
            })
            ->when($status === 'active', fn (Builder $query) => $query->whereNull('deleted_at')->where('is_active', true))
            ->when($status === 'inactive', fn (Builder $query) => $query->whereNull('deleted_at')->where('is_active', false))
            ->when($status === 'deleted', fn (Builder $query) => $query->onlyTrashed())
            ->orderBy('sort_order')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.categories.index', compact('categories', 'search', 'status'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::query()->create($request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function show(int $category): View
    {
        $category = Category::query()->withTrashed()->withCount(['products' => fn (Builder $query) => $query->whereNull('deleted_at')])->findOrFail($category);

        return view('admin.categories.show', compact('category'));
    }

    public function edit(int $category): View
    {
        $category = Category::query()->withTrashed()->findOrFail($category);

        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, int $category): RedirectResponse
    {
        $category = Category::query()->withTrashed()->findOrFail($category);

        if ($category->trashed()) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot update a deleted category.');
        }

        $category->update($request->validated());

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Request $request, int $category): RedirectResponse
    {
        $category = Category::query()->withCount(['products' => fn (Builder $query) => $query->whereNull('deleted_at')])->findOrFail($category);

        if ($category->trashed()) {
            return redirect()->route('admin.categories.index')->with('error', 'Category is already deleted.');
        }

        $confirmed = $request->boolean('confirm_delete');
        if (! $confirmed) {
            return redirect()->route('admin.categories.index')->with('error', "Delete is blocked. {$category->products_count} related product(s) will be affected. Please confirm deletion.");
        }

        DB::transaction(function () use ($category): void {
            $category->products()->whereNull('deleted_at')->delete();
            $category->delete();
        });

        return redirect()->route('admin.categories.index')->with('success', "Category soft deleted successfully. {$category->products_count} product(s) were soft deleted.");
    }

    public function forceDelete(Request $request, int $category): RedirectResponse
    {
        $categoryModel = Category::query()->withTrashed()->withCount(['products' => fn (Builder $query) => $query->withTrashed()])->findOrFail($category);

        if (! $categoryModel->trashed()) {
            return redirect()->route('admin.categories.index')->with('error', 'You can only force delete a soft deleted category.');
        }

        $confirmed = $request->boolean('confirm_delete');
        if (! $confirmed) {
            return redirect()->route('admin.categories.index')->with('error', "Force delete is blocked. {$categoryModel->products_count} related product(s) will be permanently deleted. Please confirm deletion.");
        }

        DB::transaction(function () use ($categoryModel): void {
            $categoryModel->products()->withTrashed()->forceDelete();
            $categoryModel->forceDelete();
        });

        return redirect()->route('admin.categories.index')->with('success', "Category permanently deleted successfully. {$categoryModel->products_count} product(s) were permanently deleted.");
    }

    public function toggleStatus(int $category): RedirectResponse
    {
        $category = Category::query()->withTrashed()->findOrFail($category);

        if ($category->trashed()) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot change status for a deleted category.');
        }

        $category->update(['is_active' => ! $category->is_active]);

        return redirect()->route('admin.categories.index')->with('success', 'Category status updated successfully.');
    }

    public function bulkAction(BulkCategoryActionRequest $request): RedirectResponse
    {
        $action = $request->validated('action');
        $ids = $request->validated('category_ids');

        $categories = Category::query()->withTrashed()->whereIn('id', $ids)->get();

        if ($categories->isEmpty()) {
            return redirect()->route('admin.categories.index')->with('error', 'No categories found for bulk action.');
        }

        if ($action === 'activate' || $action === 'deactivate') {
            $updated = $categories->whereNull('deleted_at')->each(fn (Category $category) => $category->update(['is_active' => $action === 'activate']))->count();
            $skipped = $categories->count() - $updated;

            return redirect()->route('admin.categories.index')->with('success', "Bulk status update completed. Updated: {$updated}, Skipped (deleted): {$skipped}.");
        }

        $deletedCategories = 0;
        $deletedProducts = 0;

        DB::transaction(function () use ($categories, &$deletedCategories, &$deletedProducts): void {
            foreach ($categories as $category) {
                if ($category->trashed()) {
                    continue;
                }

                $count = $category->products()->whereNull('deleted_at')->count();
                $category->products()->whereNull('deleted_at')->delete();
                $category->delete();
                $deletedCategories++;
                $deletedProducts += $count;
            }
        });

        return redirect()->route('admin.categories.index')->with('success', "Bulk soft delete completed. Categories: {$deletedCategories}, Products soft deleted: {$deletedProducts}.");
    }
}
