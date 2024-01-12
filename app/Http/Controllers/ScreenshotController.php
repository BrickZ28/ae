<?php

namespace App\Http\Controllers;

use App\Models\Screenshot;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use RealRashid\SweetAlert\Facades\Alert;

class ScreenshotController extends Controller
{
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

    function uploadFileToS3($file, $parent_folder): string
    {

        $name = $file->getClientOriginalName();
        $filePath = $parent_folder.'/'.$name.'_'.time();
        dd(Storage::disk('digitalocean')->put($filePath, file_get_contents($file), 'public'));
        Storage::disk('digitalocean')->put($filePath, file_get_contents($file), 'public');

        return $filePath;
    }


	public function store(Request $request)
	{
dd(Storage::disk('do')->putFile('images', request()->file, 'public'));
        if(Storage::disk('digitalocean')->putFile('images', request()->file, 'public')){
            dd(123);
        }

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
