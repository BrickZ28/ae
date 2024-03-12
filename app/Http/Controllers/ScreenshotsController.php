<?php

namespace App\Http\Controllers;

use App\Models\Screenshot;
use App\Models\User;
use App\Traits\FileTrait;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScreenshotsController extends Controller
{
    use FileTrait;

    public function index()
    {
        $pending_screenshots = Screenshot::with('uploader.userProfile')->where('approved', 0)->get();

        $filters = ['title', 'path', 'uploaded_by', 'view', 'approve', 'delete', 'created_at'];

        return view('dashboard.screenshot.index', compact('pending_screenshots', 'filters'));
    }

    public function create()
    {
        return view('dashboard.screenshot.create')->with([
            'users' => User::get()->sortBy('username'),
        ]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'file' => 'required|image',
        ]);

        $path = $this->uploadFile('do', 'images', $request->file, 'public');

        if ($path) {
            // Check if the user has 'In the Shadows' or 'Owner' role
            $userHasRequiredRole = Auth::user()->roles()->whereIn('role_name', ['In the Shadows', 'Owner'])->exists();

            // Set 'approved' to 1 if the user has one of the required roles, otherwise 0
            $approved = $userHasRequiredRole ? 1 : 0;

            Screenshot::create([
                'title' => $request->title,
                'path' => config('constants.buckets.DO_BUCKET_CDN').$path,
                'uploaded_by' => Auth::id(),
                'approved' => $approved,
            ]);
        }

        return redirect(route('dashboard.index'));

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

        if (Storage::disk('do')->delete($screenshot->path)) {
            // Optional: Delete the Screenshot model or perform other cleanup
            $screenshot->delete();

            return back()->with('success', 'Screenshot and file deleted successfully.');
        } else {
            return back()->with('error', 'Failed to delete the screenshot file.');
        }
    }

    public function approve($id)
    {
        $screenshot = Screenshot::find($id);
        if ($screenshot) {
            $screenshot->approved = 1;
            $screenshot->save();

            // Correctly chain the methods
            return redirect()->route('screenshots.index')->with('success', 'Screenshot approved!');
        }

        // Consider adding an else clause to handle the case where $screenshot is null
        return redirect()->route('screenshots.index')->withErrors('Screenshot not found.');
    }
}
