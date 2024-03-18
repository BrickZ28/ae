<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View; // Ensure you use the Auth facade

class UserViewComposer
{
    public function compose(View $view)
    {
        $view->with('user', Auth::user()); // Directly pass the authenticated user to the view
    }
}
