<?php

namespace App\Http\Controllers;

use App\Models\Specials;
use App\Services\DateRangeParser;
use App\Services\SpecialsService;
use Illuminate\Http\Request;

class SpecialsController extends Controller
{
    protected $dateRangeParser;
    protected $specialsService;

    public function __construct(DateRangeParser $dateRangeParser, SpecialsService $specialsService)
    {
        $this->dateRangeParser = $dateRangeParser;
        $this->specialsService = $specialsService;
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

        $data = $this->getArr($request);

        // Create a new record in the Specials model
        Specials::create($data);

        // Redirect back to the dashboard index page
        return redirect()->route('dashboard.index')->with('success', 'Special created successfully');
	}


	public function update(Request $request, $id)
	{
        $data = $this->getArr($request);

        $special = Specials::find($id);
        $special->update($data);



		return redirect()->route('dashboard.index')->with('success', 'Special updated successfully');
	}

    public function show(Specials $specials)
    {
        return $specials;
    }
	public function destroy(Specials $specials)
	{
		$specials->delete();

        return redirect()->route('dashboard.index')->with('success', 'Special deleted successfully');
	}

    /**
     * @param Request $request
     * @return array
     */
    public function getArr(Request $request): array
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

        // Handle the case when the 'active' checkbox is unchecked
        $data['active'] = $data['active'] ?? 0;

        // Unset the original dates field
        unset($data['dates']);
        return $data;
    }

    public function showCalendar()
    {

        return $this->specialsService->fetchForCalendar();
    }
}
