<?php


namespace App\Services\UploadServices;


use App\Repositories\UploadRepository;
use Illuminate\Support\Facades\Storage;
use WebPConvert\WebPConvert;

class UploadByAWSService implements UploadInterface
{
    protected $uploadRepo;
    protected $storage;

    public function __construct(UploadRepository $uploadRepo, Storage $storage)
    {
        $this->uploadRepo = $uploadRepo;
        $this->storage = $storage::disk('s3');
    }

    /**
     * @param string $path
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function get(string $path)
    {
        return $this->storage->get($path);
    }

    /**
     * @param array $file
     * @return string
     */
    public function send(array $file)
    {
        $path = $this->uploadRepo->generatePath($file['model'], $file['model_id'], $file['uuid'], $file['extension'], true);
        $fileUploaded = $this->storage
            ->putFileAs(
                $path,
                $file['content'],
                $file['uuid'] . '.' . $file['extension']
            );

        return $fileUploaded ? "true" : "false";
    }

    /**
     * @param string $path
     * @return bool
     */
    public function delete(string $path)
    {
        $file = $this->storage
            ->delete($path);

        return $file;
    }

    /**
     * @param string|null $directory
     * @return array
     */
    public function getAllFilesFromDirectory(string $directory = null)
    {
        return $this->storage->files($directory);
    }
}
