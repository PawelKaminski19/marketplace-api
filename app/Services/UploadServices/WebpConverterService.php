<?php


namespace App\Services\UploadServices;


use Illuminate\Support\Facades\Storage;
use WebPConvert\WebPConvert;
use Illuminate\Http\File;

class WebpConverterService
{
    public function convertToWebp($path)
    {
        $originalPath = $path;
        $path = storage_path() . "/app/" . $path;
        $pathExploded = explode(".", $path);
        $destination = $pathExploded[0] . ".webp";

        WebPConvert::convert($path, $destination, ['quality' => 75]);

        $fileJPGExists = Storage::disk('local')->exists($originalPath);
        $fileWEBP = explode(".", $originalPath);
        $fileWEBP = $fileWEBP[0] . ".webp";
        $fileWEBPExists = Storage::disk('local')->exists($fileWEBP);
        $fileWEBPath = Storage::disk('local')->path($fileWEBP);

        if ($fileJPGExists && $fileWEBPExists) {
            return new File($fileWEBPath);
        }

        return "false";
    }
}
