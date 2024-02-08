<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginUserRequest;
use App\Http\Requests\V1\StoreUserRequest;
use App\Models\User;
use App\Traits\Responses\HttpResponses;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());

        if (!Auth::attempt($request->only('discord_id'))){
            return $this->error('', 'Credentials Invalid', '401');
        }

        $user = User::where('discord_id', $request->discord_id)->first();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of' . $user->name)->plainTextToken
        ]);
    }

    public function register(StoreUserRequest $request)
    {
        $request->validated($request->all());
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return $this->success([
                'user' => $user,
                'token' => $user->createToken('API Token of' . $user->name)->plainTextToken
            ]
        );
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->success([
            'message' => 'Logged Out'
        ]);
    }

}
