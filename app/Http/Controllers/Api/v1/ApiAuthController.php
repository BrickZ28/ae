<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\LoginUserRequest;
use App\Http\Requests\V1\StoreUserRequest;
use App\Models\User;
use App\Traits\Responses\HttpResponses;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    use HttpResponses;

    public function login(LoginUserRequest $request)
    {
        $check_login = DB::table('personal_access_tokes')->where('name', $request->discord_id)->first()
        if ($check_login){
            return $this->success([
                'token' => $check_login->token
            ]);
        }
        $request->validated($request->all());

        $user = User::where('discord_id', $request->discord_id)->first();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token of' . $user->discord_id)->plainTextToken
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
