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
        return view('dashboard.package.edit', compact('package', 'items'));
    }




}
