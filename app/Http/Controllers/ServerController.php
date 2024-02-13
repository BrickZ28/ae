<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ServerController extends Controller
{
	public function index()
	{

	}

	public function create()
	{
        return view('dashboard.server.create');
	}

	public function store(Request $request)
	{
        $request->validate([
            'name' => 'required',
        ]);

        if(Server::create([
            'name' => $request->name,
            'ip' => $request->ip,
        ])) {
            Alert::success('Server Created', 'New server created successfully');
        }

        return view('dashboard.index');
    }


	public function show(Server $server)
	{
	}

	public function edit(Server $server)
	{
	}

	public function update(Request $request, Server $server)
	{
	}

	public function destroy(Server $server)
	{
	}
}
