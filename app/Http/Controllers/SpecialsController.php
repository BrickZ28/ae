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
		return Specials::all();
	}

    public function create()
    {
        return view('dashboard.special.create');
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

	public function update(Request $request, Specials $specials)
	{
		$data = $request->validate([
			'title' => ['required'],
			'description' => ['required'],
			'discount' => ['required', 'numeric'],
			'start_date' => ['required', 'date'],
			'end_date' => ['required', 'date'],
			'usuage_limit' => ['nullable', 'integer'],
			'active' => ['boolean'],
		]);

		$specials->update($data);

		return $specials;
	}

	public function destroy(Specials $specials)
	{
		$specials->delete();

		return response()->json();
	}
}
