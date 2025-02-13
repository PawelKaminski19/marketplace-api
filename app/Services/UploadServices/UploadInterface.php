<?php
namespace App\Services\UploadServices;


interface UploadInterface
{
    /**
     * @param array $file
     * @return mixed
     */
    public function send(array $file);

    /**
     * @param string $path
     * @return mixed
     */
    public function delete(string $path);

    /**
     * @param string $directory
     * @return mixed
     */
    public function getAllFilesFromDirectory(string $directory);

    /**
     * @param string $path
     * @return mixed
     */
    public function get(string $path);
}
