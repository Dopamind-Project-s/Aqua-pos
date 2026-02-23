<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->withTrashed()
            ->latest()
            ->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::query()->create($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category): View
    {
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category soft deleted successfully.');
    }

    public function forceDelete(int $category): RedirectResponse
    {
        $categoryModel = Category::query()->withTrashed()->findOrFail($category);

        if (! $categoryModel->trashed()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'You can only force delete a soft deleted category.');
        }

        $categoryModel->forceDelete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category permanently deleted successfully.');
    }

    public function toggleStatus(Category $category): RedirectResponse
    {
        if ($category->trashed()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Cannot change status for a deleted category.');
        }

        $category->update([
            'is_active' => ! $category->is_active,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category status updated successfully.');
    }
}
