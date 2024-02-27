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
            // Attempt to upload the file to the specified disk (e.g., S3)
            $path = Storage::disk($disk)->putFile($folder, $file, $visibility);

            // Check if the path is returned successfully
            if ($path) {
                Alert::success('File uploaded', 'File uploaded successfully');
                return $path;
            } else {
                // If the path is not returned, consider it a failed upload
                Alert::error('File upload failed', 'The file could not be uploaded.');
                return false;
            }
        } catch (\Exception $e) {
            // Catch any exceptions and report the failure
            Alert::error('File upload failed', 'An error has occurred during upload: ' . $e->getMessage());
            return false;
        }
    }


}
