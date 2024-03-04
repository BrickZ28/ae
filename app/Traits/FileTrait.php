<?php

namespace App\Traits;

use App\Models\Screenshot;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

trait FileTrait
{
    public function uploadFile($disk, $folder, $file, $visibility = 'public'): bool|string
    {
        try {
            // Attempt to upload the file to the specified disk
            $path = Storage::disk($disk)->putFile($folder, $file, $visibility);

            // Check if the path is returned successfully
            if ($path) {
                // Redirect to a specific route with a success message
                return redirect()->route('dashboard.index')->with('success', 'File uploaded successfully');
            } else {
                // If the path is not returned, consider it a failed upload
                // Redirect to a specific route with an error message
                return redirect()->route('dashboard.index')->with('error', 'The file could not be uploaded.');
            }
        } catch (\Exception $e) {
            // Catch any exceptions and report the failure
            // Redirect to a specific route with an error message including the exception message
            return redirect()->route('dashboard.index')->with('error', 'An error has occurred during upload: ' . $e->getMessage());
        }

    }

    public function deleteFile($disk, $filePath)
    {

        try {
            // First, check if the file path is not null and is a string
            if (is_string($filePath) && !empty($filePath)) {
                // Check if the file exists before attempting to delete
                if (Storage::disk($disk)->exists($filePath)) {
                    // Delete the file
                    Storage::disk($disk)->delete($filePath);
                    dd('Success', 'File deleted successfully.');
                    return true;
                } else {
                    dd('Error', 'File does not exist.');
                    return false;
                }
            } else {
                // File path is not valid
                dd('Error', 'Invalid file path.');
                return false;
            }
        } catch (\Exception $e) {
            // Catch any exceptions and report the failure
            dd('Error', 'An error has occurred: ' . $e->getMessage());
            return false;
        }
    }



}
