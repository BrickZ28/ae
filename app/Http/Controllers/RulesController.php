<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;




class RulesController extends Controller
{
	public function index()
	{
        return view('dashboard.rules.index')->with([
            'rules' => Rule::all(),
            'filters' => ['priority', 'rule', 'created'],
        ]);
	}
    public function create()
    {
        return view('dashboard.rules.create');
    }
	public function store(Request $request)
	{
        if($request->validate([
             'rule' => 'required',
             'priority' => 'required|min:1|max:2|numeric',
         ])) {
            Alert::success('Rule Created', 'New rule created successfully');
        }

        Rule::create([
           'rule' => $request->rule,
           'priority' => $request->priority,
        ]);

        return view('dashboard.index');
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
