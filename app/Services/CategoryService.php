<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryService
{
    public function index()
    {
        $categories = Category::all();
        $filters = ['id', 'name', 'description', 'created on', 'Updated on', 'edit', 'delete'];

        return view('dashboard.category.index', compact('categories', 'filters'));
    }

    public function create()
    {
        return view('dashboard.category.create');
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateCategory($request);

        $categoryCreated = Category::create($validatedData);

        if ($categoryCreated) {
            return redirect()->route('categories.create')->with('success', 'New category created successfully');
        } else {
            return back()->with('error', 'Failed to create a new category. Please try again.')->withInput();
        }
    }

    public function edit(Category $category)
    {
        return view('dashboard.category.edit')->with([
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $this->validateCategory($request);

        $categoryUpdated = $category->update($validatedData);

        if ($categoryUpdated) {
            return redirect()->route('dashboard.index')->with('success', 'Category updated successfully');
        } else {
            return back()->with('error', 'Failed to update the category. Please try again.')->withInput();
        }
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('dashboard.index')->with('success', 'Category deleted successfully');
    }

    private function validateCategory(Request $request)
    {
        return $request->validate([
            'name' => 'required',
            'description' => 'max:255'
        ]);
    }
}
