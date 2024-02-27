<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\userProfile;
use Illuminate\Http\Request;

class UserProfileController extends Controller
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

	public function show($id)
	{
        $user = User::find($id);
        return view('dashboard.users.show', compact('user'));
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
