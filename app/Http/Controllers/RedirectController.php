<?php

namespace App\Http\Controllers;

class RedirectController extends Controller
{
    protected function backWithSuccess($message)
    {
        return back()->with('success', $message);
    }

    protected function backWithError($message)
    {
        return back()->with('error', $message);
    }

    protected function handleServiceResult($result)
    {
        if ($result['status'] === 'success') {
            return $this->toDashboardWithSuccess($result['message']);
        } else {
            return $this->toDashboardWithError($result['message']);
        }
    }

    protected function toDashboardWithSuccess($message)
    {
        return redirect()->route('dashboard.index')->with('success', $message);
    }

    protected function toDashboardWithError($message)
    {
        return redirect()->route('dashboard.index')->with('error', $message);
    }
}
