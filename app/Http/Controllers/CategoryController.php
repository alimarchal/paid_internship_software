<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('questions')->orderBy('name')->get();

        return view('settings.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('settings.categories.form', ['category' => new Category()]);
    }

    public function store(Request $request)
    {
        Category::create($this->validated($request));

        return to_route('settings.categories.index')->with('success', 'Category added.');
    }

    public function edit(Category $category)
    {
        return view('settings.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $category->update($this->validated($request));

        return to_route('settings.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->questions()->exists()) {
            return back()->with('error', 'This category has questions, so it cannot be deleted.');
        }

        $category->delete();

        return to_route('settings.categories.index')->with('success', 'Category deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);
    }
}
