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
    $method = $result['redirectTo'] . 'With' . ucfirst($result['status']);

    if (method_exists($this, $method)) {
        return $this->$method($result['message']);
    }

// Handle the case where the method does not exist
        return back()->with('error', 'An error occurred while processing your request.');
    }
    protected function dashboardWithSuccess($message)
    {
        return redirect()->route('dashboard.index')->with('success', $message);
    }

    protected function dashboardWithError($message)
    {
        return redirect()->route('dashboard.index')->with('error', $message);
    }
}
