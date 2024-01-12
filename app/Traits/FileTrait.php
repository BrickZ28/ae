<?php

namespace App\Traits;

use App\Models\Screenshot;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

trait FileTrait
{
    public function uploadFile($disk, $folder, $file, $visibility): bool|string
    {
        //uploading to disk
        $path = Storage::disk($disk)->putFile($folder, $file, $visibility);
        if($path) {
            Alert::success('File uploaded', 'File uploaded successfully');
            return $path;
        }

        Alert::error('File upload failed', 'An error has occurred during upload');
        return false;
    }


}
