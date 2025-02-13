<?php
namespace App\Services\UploadServices;

use App\Repositories\UploadRepository;
use Illuminate\Support\Facades\Storage;

class UploadByLocalService implements UploadInterface
{
    protected $uploadRepo;
    protected $storage;

    public function __construct(Storage $storage)
    {
        $this->storage = $storage::disk('local');
    }

    public function get(string $path)
    {
        return $this->storage->get($path);
    }

    public function getAllFilesFromDirectory(string $directory = '*')
    {
        return $this->storage->allFiles($directory);
    }

    public function send(array $file)
    {
        return $this->storage->putFile('tmp', $file['content']);
    }

    public function delete(string $path)
    {
        return $this->storage->delete($path);
    }
}
