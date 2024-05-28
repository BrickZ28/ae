<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {

    }

    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'color' => 'required',
        ]);

        if (Status::create([
            'name' => $request->status,
            'color' => $request->color,
        ])) {
            return redirect()->route('dashboard.index')->withSuccess('New status created successfully');
        }

        return redirect()->route('dashboard.index')->with('error', 'Status creation failed');
    }

    public function create()
    {
        return view('dashboard.status.create');
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
