<?php

namespace App\Traits;

use App\Models\Screenshot;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

trait FileTrait
{
    public function uploadFile($disk, $folder, $file, $visibility = 'public')
    {
        try {
            // Generate a unique filename based on the original filename or you can set a specific name
            // This example uses the original file name. Ensure you sanitize or create a naming convention as needed.
            $filename = $file->getClientOriginalName();

            // Define the full path where the file should be stored and overwrite if it exists
            $fullPath = $folder . '/' . $filename;

            // Use putFileAs to store the file to the specified path on the disk
            $path = Storage::disk($disk)->putFileAs($folder, $file, $filename, $visibility);

            if ($path) {
                // If the file is stored successfully, redirect with a success message
                return redirect()->route('dashboard.index')->with('success', 'File uploaded successfully.');
            } else {
                // If the storage was unsuccessful, redirect with an error message
                return redirect()->route('dashboard.index')->with('error', 'The file could not be uploaded.');
            }
        } catch (\Exception $e) {
            // If an error occurs, catch the exception and redirect with an error message
            return redirect()->route('dashboard.index')->with('error', 'An error has occurred during upload: ' . $e->getMessage());
        }
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
