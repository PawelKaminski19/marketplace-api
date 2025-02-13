<?php
namespace App\Services\UploadServices;

use App\Models\Setting;
use App\Models\Upload;
use App\Models\User;
use App\Repositories\UploadRepository;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use WebPConvert\WebPConvert;

class UploadService
{
    const HASH_SALT = '91435gv1pfn293!fcyrbv1o2rgqo8i3742';

    /**
     * UploadController constructor.
     * @param WebpConverterService $webpConverter
     */
    public function __construct(WebpConverterService $webpConverter)
    {
        $this->webpConverter = $webpConverter;
    }

    /**
     * Get URL of uploaded file.
     *
     * @param Upload $upload
     * @param bool $public
     * @return string
     */
    public function getURL(Upload $upload, $public = true)
    {
        if (!$upload->complete) return null;

        return Storage::disk('s3')->url($this->getPath($upload->model, $upload->model_id, $public).'/'.$upload->uuid.'.'.$upload->extension);
    }


    /**
     * Get path for the object.
     *
     * @param string|object $model
     * @param int $modelId
     * @param bool $public
     * @return string
     */
    public function getPath($model, $modelId, $public = true)
    {
        $date = Carbon::now();
        if (is_object($model)) {
            $model = get_class($model);
        }
        return implode('/', [$public ? 'public' : 'private', $this->getHash($model), $date->year, $date->month, $modelId]);
    }

    /**
     * Get hash of the value.
     *
     * @param string $value
     * @return string
     */
    protected function getHash($value)
    {
        return md5(self::HASH_SALT.$value);
    }

    /**
     * Check if the hash matches with the given string (basically given class(model) name).
     *
     * @param string $className
     * @param string $hash
     * @return bool
     */
    public function isHashCorrect($className, $hash)
    {
        return $this->getHash($className) == $hash;
    }

    public function imageToWebp(string $path, Setting $settings)
    {
        // TODO Refactoring required
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

    public function storeFileInTemp(UploadedFile $file, string $path = 'tmp', string $filename = null)
    {
        if ($filename) {
            return Storage::disk('local')->putFileAs($path, $file, $filename);
        }
        return Storage::disk('local')->putFile($path, $file);
    }

    public function storeFileInAws($file, string $path, string $filename = null, $public = true)
    {
        $storage = Storage::disk('s3');
        $options = [];

        if ($public) {
            $options['visibility'] = 'public';
        }

        if ($filename) {
            return $storage->putFileAs($path, $file, $filename, $options);
        }
        return $storage->putFile($path, $file, $options);
    }

    public function removeFilesFromTemp(string $path)
    {
        return Storage::disk('local')->deleteDirectory($path);
    }

    public function removeFilesFromAws(string $path)
    {
        return Storage::disk('s3')->deleteDirectory($path);
    }
}
