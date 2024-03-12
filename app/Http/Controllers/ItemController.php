<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
	public function index()
	{
        $items = Item::with('category')->get();
        $filters = ['name', 'category', 'price', 'Updated on', 'view', 'edit', 'delete'];

        return view('dashboard.item.index', compact('items', 'filters'));
	}

	public function create()
	{
        $categories = Category::all();
        return view('dashboard.item.create', compact('categories'));
	}

	public function store(Request $request)
	{
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'currency_type' => 'required',
            'price' => 'required',
        ]);

        // Attempt to create the Category and capture the result
        $itemCreated = Item::create($validatedData);

        if ($itemCreated) {
            // If the category is successfully created, redirect with success message
            return redirect()->route('dashboard.index')->with('success', 'New item created successfully');
        } else {
            // If the category creation fails, redirect back with an error message
            // This is more of a precautionary measure, as create() typically throws an exception on failure
            return back()->with('error', 'Failed to create a new item. Please try again.')->withInput();
        }
	}

	public function show(Item $item)
	{
	}

	public function edit(Item $item)
	{
	}

	public function update(Request $request, Item $item)
	{
	}

	public function destroy(Item $item)
	{
	}
}
