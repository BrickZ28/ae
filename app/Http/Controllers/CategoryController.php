<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $data = [
            'columns' => ['Name', 'Age', 'Email'],
            'rows' => [
                ['John Doe', 30, 'john@example.com'],
                ['Jane Smith', 25, 'jane@example.com'],
                // Add more rows as needed
            ]
        ];

        return view('dashboard.category.index', ['data' => $data]);
    }

	public function create()
	{
	}

	public function store(Request $request)
	{
	}

	public function show($id)
	{

	}

	public function edit($id)
	{
	}

	public function update(Request $request, $id)
	{
	}

	public function destroy($id)
	{
	}
}
