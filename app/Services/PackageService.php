<?php

namespace App\Services;


use App\Models\Category;
use App\Models\Item;
use App\Models\Package;
use App\Traits\FileTrait;
use Illuminate\Http\Request;

class PackageService
{
    use FileTrait;

    public function index()
    {
        $packages = Package::with('items')->get();
        $filters = ['name', 'price', 'Visible', 'Updated on', 'view', 'edit', 'delete'];
        return view('dashboard.package.index', compact('packages', 'filters'));

    }

    public function create()
    {

        $categories = Category::with('items')->get();
        return view('dashboard.package.create', compact('categories'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'items' => 'required|array',
            'items.*' => 'exists:items,id', // Ensure all selected items exist in the items table
            'price' => 'required|numeric',
            'currency_type' => 'required|string',
            'image' => 'nullable|file|image|max:2048', // Adjusted image validation
            'active' => 'boolean|nullable', // Adjusted based on form input name
        ]);


        $packageData = [
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'currency_type' => $validatedData['currency_type'],
        ];

        // Check if 'image' key exists in the validated data array
        if (array_key_exists('image', $validatedData)) {
            $packageData['image'] = $validatedData['image'];
            $this->uploadFile('do','images/packages', $request->file, 'public');
        }

        // Check if 'visible' key exists in the validated data array
        if (array_key_exists('visible', $validatedData)) {
            $packageData['visible'] = $validatedData['visible'];
        }

        $package = Package::create($packageData);


        $package->items()->attach($validatedData['items']);


        return redirect()->route('packages.index')->with('success', 'New package created successfully');
    }

    public function edit(Package $package)
    {
        $items = Item::all();
        $categories = Category::with('items')->orderBy('name')->get();

        return view('dashboard.package.edit', compact('package', 'items', 'categories'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'currency_type' => 'required|string',
            'visible' => 'sometimes|boolean',
            'new_items' => 'sometimes|array',
            'new_items.*' => 'exists:items,id',
            'existing_items' => 'sometimes|array', // Array of all existing item IDs in the package
            'existing_items.*' => 'exists:items,id',
            'items_to_keep' => 'sometimes|array', // Array of item IDs that should remain checked (kept in the package)
            'items_to_keep.*' => 'exists:items,id',
            // Include validation for the image if necessary
        ]);

        // Update package details
        $package->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'currency_type' => $validated['currency_type'],
            'active' => $validated['visible'] ?? false,
        ]);

        // Handle image upload if included in the form
        // Assuming uploadFile is a method that handles file upload and returns the file path
        if ($request->hasFile('image')) {
            $imagePath = $this->uploadFile($request->file('image'), 'images/packages', 'public');
            $package->image = $imagePath;
            $package->save();
        }

        // Add new items
        if (!empty($validated['new_items'])) {
            $package->items()->syncWithoutDetaching($validated['new_items']);
        }

        // Find items to remove: those in 'existing_items' but not in 'items_to_keep'
        $itemsToRemove = array_diff($validated['existing_items'] ?? [], $validated['items_to_keep'] ?? []);

        // Detach items to be removed
        if (!empty($itemsToRemove)) {
            $package->items()->detach($itemsToRemove);
        }

        return redirect()->route('packages.index', $package->id)->with('success', 'Package updated successfully.');
    }






}
