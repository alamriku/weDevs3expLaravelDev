<?php


namespace App\Services;





use Illuminate\Support\Facades\Storage;

class FileService
{
    public function storeFile($data)
    {

        $file = $data->file('image');
        $path = Storage::disk('public')->put('images',$file);
        return 'storage/'.$path;
    }

    public function removeFile($filePath)
    {
        $filePath = str_replace('storage/' , '', $filePath);
        Storage::delete("public/".$filePath);
    }
}