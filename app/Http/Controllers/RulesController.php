<?php

namespace App\Http\Controllers;

use App\Http\Resources\V1\Rules\RuleResource;
use App\Models\Rule;
use Auth;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class RulesController extends Controller
{
	public function index()
	{
        return view('dashboard.rules.index')->with([
            'rules' => Rule::all(),
            'filters' => ['id', 'priority', 'rule', 'last updated', 'created on', 'created by', 'actions']
        ]);
	}
    public function create()
    {
        return view('dashboard.rules.create');
    }
	public function store(Request $request)
	{
        $request->validate([
             'rule' => 'required',
             'priority' => 'required|min:1|max:2|numeric',
         ]);

        if(Rule::create([
           'rule' => $request->rule,
           'priority' => $request->priority,
           'user_id' => Auth::id(),
        ])) {
        Alert::success('Rule Created', 'New rule created successfully');
    }

        return view('dashboard.index');
	}

	public function show($id)
	{

	}

	public function edit($id)
	{
        return view('dashboard.rules.edit')->with([
            'rule' => Rule::find($id),
        ]);
	}

	public function update(Request $request, $id)
	{
        $request->validate([
            'rule' => 'required',
            'priority' => 'required|min:1|max:2|numeric',
        ]);

        $rule = Rule::find($id);
        $rule->rule = $request->rule;
        $rule->priority = $request->priority;

        if ($rule->save()){
            Alert::success('UPdated', 'Rule Updated');
        } else {
            Alert::error('Failed', 'Rule failed to update');
        }

        return view('dashboard.index');
	}

	public function destroy($id)
	{
	}

    public function apiRulesIndex()
    {
        return RuleResource::collection(Rule::all());
    }
}
