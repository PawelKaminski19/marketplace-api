<?php


namespace App\Repositories;

use App\Models\Upload;
use App\Services\UploadServices\UploadByLocalService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class UploadRepository extends BaseRepository
{
    protected $model;
    protected $localStorage;

    /**
     * UploadRepository constructor.
     * @param Upload $model
     */
    public function __construct(Upload $model, UploadByLocalService $localStorage)
    {
        $this->model = $model;
        $this->localStorage = $localStorage;
    }

    /**
     * Get Upload Object By UUID
     *
     * @param string $uuid
     * @return string
     */
    public function getUploadByUuid(string $uuid)
    {
        $upload = $this->model->where('uuid', '=', $uuid)->first();

        if ($upload) {
            return $upload->toArray();
        } else {
            return "false";
        }
    }

    /**
     * Get relative path to the file
     *
     * @param int $uploadId
     * @return string
     */
    public function getPathToFile(int $uploadId)
    {
        $upload = $this->model->find($uploadId);
        $date = Carbon::parse($upload->created_at);

        $year = $date->year;
        $month = $date->month;

        if ($upload) {
            return $upload->model . '/'
                . $year . '/'
                . $month . '/'
                . $upload->model_id . '/'
                . $upload->uuid . '.'
                . $upload->extension;
        }

        return "false";
    }

    /**
     * Generate path for a new file
     *
     * @param string $model
     * @param int $model_id
     * @param string $uuid
     * @param string $extension
     * @param bool $dirOnly
     * @return string
     */
    public function generatePath(string $model, int $model_id, string $uuid, string $extension, bool $dirOnly = false)
    {
        $date = Carbon::now();
        $dir = implode('/', [$model, $date->year, $date->month, $model_id]);
        $file = implode('.', [$uuid, $extension]);

        if ($dirOnly) {
            return $dir;
        } else {
            return implode('/', [$dir, $file]);
        }
    }

    /**
     * Get Parent "Owner" for given Upload ID
     *
     * @param int $uploadId
     * @return array|string
     */
    public function getParentByUploadId(int $uploadId)
    {
        $upload = $this->model->find($uploadId);

        if ($upload) {
            $parent = "App\Models\\" . ucfirst($upload->model);
            $parent = $parent::find($upload->model_id);
            if ($parent) {
                return $parent->toArray();
            }
        }

        return "false";
    }

    /**
     * @param string $modelName
     * @param int $modelId
     * @return mixed
     */
    public function getUploadsByParent(string $modelName, int $modelId)
    {
        return $this->model->where('model', '=', lcfirst($modelName))
            ->where('model_id', '=', $modelId)
            ->get()
            ->toArray();
    }

    public function getMimetype(int $id)
    {
        $upload = $this->model->find($id);

        if ($upload) {
            return $upload->type;
        }

        return false;
    }

    public function getUrl(string $path)
    {
        return Storage::disk('s3')->url($path);
    }

    public function getLocalFiles($path = '*')
    {
        return $this->localStorage->getAllFilesFromDirectory($path);
    }

    public function getLocalFile($path)
    {
        return $this->localStorage->get($path);
    }
}
