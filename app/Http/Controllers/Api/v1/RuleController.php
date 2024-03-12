<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Rules\RuleResource;
use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    public function index()
    {
        return RuleResource::collection(Rule::all());
    }

    public function store(Request $request)
    {
    }

    public function show(Rule $rule)
    {
    }

    public function update(Request $request, Rule $rule)
    {
    }

    public function destroy(Rule $rule)
    {
    }
}
