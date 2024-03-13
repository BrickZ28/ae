<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Traits\FileTrait;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    use FileTrait;
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
            'image' => 'image',
        ]);

        if ($request->hasFile('image')) {
            $path = $this->uploadFile('do','images/items', $request->image, 'public');
        }

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
        $categories = Category::all();
        return view('dashboard.item.edit', compact('item', 'categories'));
	}

    public function update(Request $request, Item $item)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'currency_type' => 'required',
            'price' => 'required',
            // Note: 'image' validation is handled separately
        ]);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $request->validate([
                'image' => 'image|max:2048', // Validate the image only if it's present
            ]);

            $path = $request->file('image')->store('images/items', 'public');
            $validatedData['image_path'] = $path; // Add or update the path
        }

        $item->update($validatedData);

        return redirect()->route('dashboard.index')->with('success', 'Item updated successfully');
    }


    public function destroy(Item $item)
    {
        // Check if the item has a path for an image and if it exists
        if ($item->path && Storage::disk('do')->exists($item->path)) {
            // Attempt to delete the image
            $imageDeleted = Storage::disk('do')->delete($item->path);

            if (!$imageDeleted) {
                // If the image deletion fails, return with an error message
                return back()->with('error', 'Failed to delete the item image.');
            }
        }

        // If there's no image or if the image was successfully deleted, delete the item
        $item->delete();

        return back()->with('success', 'Item deleted successfully.');
    }

}
