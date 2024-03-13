<?php

namespace App\Services;


class PackageService
{

    public function index()
    {
        return view('dashboard.package.index');
    }

    public function create()
    {
        $items = Item::all();
        return view('dashboard.package.create', compact('items'));
    }

}
