<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Item;
use App\Traits\FileTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ItemService
{
    use FileTrait;

    private function getFilters()
    {
        if(auth()->user()->hasAnyRole(['Owners', 'Head Admin'])){
            $filters = ['name', 'category', 'price', 'Updated on', 'view', 'edit', 'delete'];
        } else {
            $filters = ['image', 'name', 'price', 'Last update', 'View', 'add to cart', 'view cart'];
        }

        return $filters;
    }
    public function index()
    {
        $items = Item::where('active', 1)->with('category')->get();
        $filters = $this->getFilters();

        if(auth()->user()->hasAnyRole([ 'Owners', 'Head Admin'])){
            return view('dashboard.item.index', compact('items', 'filters'));
        } else {
            return view('buyer.item.index', compact('items', 'filters', ));
        }

    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.item.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateItem($request);

        $itemCreated = Item::create($validatedData);

        if ($request->hasFile('image')) {
            $this->uploadFile('do','images/items', $request->image, 'public');
        }

        if ($itemCreated) {
            return redirect()->route('items.create')->with('success', 'New item created successfully');
        } else {
            return back()->with('error', 'Failed to create a new item. Please try again.')->withInput();
        }
    }

    public function edit(Item $item)
    {
        $categories = Category::all();
        return view('dashboard.item.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $validatedData = $this->validateItem($request);

        $item->update($validatedData);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $this->uploadFile('do','images/items', $request->image, 'public');
        }

        return redirect()->route('dashboard.index')->with('success', 'Item updated successfully');
    }

    public function destroy(Item $item)
    {
        if ($item->image_path && Storage::disk('public')->exists($item->image_path)) {
            Storage::disk('public')->delete($item->image_path);
        }

        $item->delete();

        return back()->with('success', 'Item deleted successfully.');
    }

    private function validateItem(Request $request)
    {
        return $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'category_id' => 'required',
            'currency_type' => 'required',
            'price' => 'integer|required',
            'image' => 'image|nullable',
            'active' => 'boolean|nullable',
        ]);
    }


}
