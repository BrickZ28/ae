<?php

namespace App\Http\Controllers;

use App\Models\Specials;
use App\Services\DateRangeParser;
use Illuminate\Http\Request;

class SpecialsController extends Controller
{
    protected $dateRangeParser;

    public function __construct(DateRangeParser $dateRangeParser)
    {
        $this->dateRangeParser = $dateRangeParser;
    }
	public function index()
	{
        return view('dashboard.special.index')->with([
            'specials' => Specials::all(),
            'filters' => ['Title', 'Started On', 'Ends', 'Active', 'discount', 'Use limit', 'actions']
        ]);
	}

    public function create()
    {
        return view('dashboard.special.create');
    }

    public function edit(Specials $special)
    {
        return view('dashboard.special.edit')->with([
            'special' => $special,
        ]);
    }

	public function store(Request $request)
	{

        $data = $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'discount' => ['nullable', 'numeric'],
            'dates' => ['required', 'string'], // Ensure dates field is a string
            'usage_limit' => ['nullable', 'integer'],
            'active' => ['boolean'],
        ]);

        [$startDate, $endDate] = $this->dateRangeParser->parse($data['dates']);

        // Add the start and end dates to the validated data
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;

        // Unset the original dates field
        unset($data['dates']);

        // Create a new record in the Specials model
        Specials::create($data);

        // Redirect back to the dashboard index page
        return redirect()->route('dashboard.index')->with('success', 'Special created successfully');
	}

	public function show(Specials $specials)
	{
		return $specials;
	}

	public function update(Request $request, $id)
	{
        $data = $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'discount' => ['nullable', 'numeric'],
            'dates' => ['required', 'string'], // Ensure dates field is a string
            'usage_limit' => ['nullable', 'integer'],
            'active' => ['boolean'],
        ]);

        [$startDate, $endDate] = $this->dateRangeParser->parse($data['dates']);

        // Add the start and end dates to the validated data
        $data['start_date'] = $startDate;
        $data['end_date'] = $endDate;

        // Unset the original dates field
        unset($data['dates']);

        $special = Specials::find($id);
        $special->update($data);



		return redirect()->route('dashboard.index')->with('success', 'Special updated successfully');
	}

	public function destroy(Specials $specials)
	{
		$specials->delete();

		return response()->json();
	}
}
