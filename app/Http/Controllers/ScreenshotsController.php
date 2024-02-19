<?php

namespace App\Http\Controllers;

use App\Models\Screenshot;
use App\Models\User;
use App\Traits\FileTrait;
use Auth;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use RealRashid\SweetAlert\Facades\Alert;

class ScreenshotsController extends Controller
{
    use FileTrait;
	public function index()
	{
		return Screenshot::all();
	}

    public function create()
    {
        return view('dashboard.screenshot.create')->with([
            'users' => User::get()->sortBy('username')
        ]);
    }

	public function store(Request $request)
	{
        $request->validate([
            'title' => 'required',
            'created_by' => 'sometimes|integer|nullable',
            'file' => 'required|image',
            ]);



        $path = $this->uploadFile('do','images', $request->file, 'public');


        if ($path) {
            Screenshot::create([
                'title' => $request->title,
                'created_by' => $request->created_by ?? Auth::id(),
                'path' => config('constants.buckets.DO_BUCKET_CDN') . $path,
                'uploaded_by' => Auth::id()
            ]);
        }
        return redirect(route('dashboard.index'));

	}

	public function show(Screenshot $screenshot)
	{
		return $screenshot;
	}

	public function update(Request $request, Screenshot $screenshot)
	{
		$request->validate([
			'title' => ['required'],
			'path' => ['required'],
			'uploaded_by' => ['required', 'integer'],
			'belongs_to' => ['required', 'integer'],
		]);

		$screenshot->update($request->validated());

		return $screenshot;
	}

	public function destroy(Screenshot $screenshot)
	{
		$screenshot->delete();

		return response()->json();
	}
}