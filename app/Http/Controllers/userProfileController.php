<?php

namespace App\Http\Controllers;

use App\Models\userProfile;
use Illuminate\Http\Request;

class userProfileController extends Controller
{
	public function index()
	{
		return userProfile::all();
	}

	public function store(Request $request)
	{
		$data = $request->validate([
			'username' => ['nullable'],
			'profile_photo_path' => ['nullable'],
			'avatar' => ['nullable'],
			'banenr' => ['nullable'],
			'local' => ['nullable'],
			'public_flags' => ['nullable', 'integer'],
		]);

		return userProfile::create($data);
	}

	public function show(userProfile $userProfile)
	{
		return $userProfile;
	}

	public function update(Request $request, userProfile $userProfile)
	{
		$data = $request->validate([
			'username' => ['nullable'],
			'profile_photo_path' => ['nullable'],
			'avatar' => ['nullable'],
			'banenr' => ['nullable'],
			'local' => ['nullable'],
			'public_flags' => ['nullable', 'integer'],
		]);

		$userProfile->update($data);

		return $userProfile;
	}

	public function destroy(userProfile $userProfile)
	{
		$userProfile->delete();

		return response()->json();
	}
}
