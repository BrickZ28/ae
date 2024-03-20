<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Services\PackageService;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    protected $packageService;

    public function __construct(PackageService $packageService)
    {
        $this->packageService = $packageService;
    }
	public function index()
	{
		return $this->packageService->index();
	}

	public function create()
	{
        return $this->packageService->create();
	}

	public function store(Request $request)
	{
       return  $this->packageService->store($request);
	}

	public function show(Package $package)
	{
	}

	public function edit(Package $package)
	{
        return $this->packageService->edit($package);
	}

	public function update(Request $request, Package $package)
	{
        return $this->packageService->update($request, $package);
	}

	public function destroy(Package $package)
	{
	}
}
