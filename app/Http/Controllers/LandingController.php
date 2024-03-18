<?php

namespace App\Http\Controllers;

use App\Models\Rule;
use App\Models\Server;
use App\Models\User;
use App\Traits\ApiRequests;

class LandingController extends Controller
{
    use ApiRequests;

    public function index()
    {
        return view('landing.index')->with([
            'users' => User::all(),
            'rules' => Rule::where('priority', 1)->limit(3)->get(),
            'servers' => Server::all(),
            'random_screen_shots' => getRandomScreenshot(),
            'specials' => getSpecials(),
            //            'online_players' => $this->getOnlinePlayerCount()
        ]);
    }
}
