<?php

namespace App\Http\Controllers;

use App\Models\Screenshot;
use App\Models\User;
use App\Models\Rule;

class LandingController extends Controller
{
	public function index()
	{
        return view('landing.index')->with([
            'users' => User::all(),
            'rules' => Rule::where('priority', 1)->limit(3)->get(),
        ]);
	}
}
