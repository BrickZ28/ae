<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth; // Ensure you use the Auth facade

class UserViewComposer
{
    public function compose(View $view)
    {
        $view->with('user', Auth::user()); // Directly pass the authenticated user to the view
    }
}
