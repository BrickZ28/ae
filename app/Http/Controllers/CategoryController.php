<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'max:255'
        ]);

        // Attempt to create the Category and capture the result
        $categoryCreated = Category::create($validatedData);

        if ($categoryCreated) {
            // If the category is successfully created, redirect with success message
            return redirect()->route('categories.create')->with('success', 'New category created successfully');
        } else {
            // If the category creation fails, redirect back with an error message
            // This is more of a precautionary measure, as create() typically throws an exception on failure
            return back()->with('error', 'Failed to create a new category. Please try again.')->withInput();
        }
    }


	public function show($id)
	{

	}

	public function edit(Category $category)
    {
        return view('dashboard.category.edit')->with([
            'category' => $category,
        ]);
    }


    public function update(Request $request, Category $category)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'max:255'
        ]);

        // Attempt to update the Category and capture the result
        $categoryUpdated = $category->update($validatedData);

        if ($categoryUpdated) {
            // If the category is successfully updated, redirect with success message
            return redirect()->route('dashboard.index')->with('success', 'Category updated successfully');
        } else {
            // If the category update fails, redirect back with an error message
            // This is more of a precautionary measure, as update() typically throws an exception on failure
            return back()->with('error', 'Failed to update the category. Please try again.')->withInput();
        }
    }

	public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('dashboard.index')->with('success', 'Category deleted successfully');
    }

}
