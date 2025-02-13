<?php

namespace App\Http\Controllers\Api\Upload;

use App\Exceptions\NoPermissionException;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\UploadRequests\StoreUploadRequest;
use App\Models\SettingsUpload;
use App\Models\Upload;
use App\Models\User;
use App\Repositories\ClientRepository;
use App\Repositories\UploadRepository;
use App\Services\UploadServices\GenericUpload;
use App\Services\UploadServices\UploadService;
use App\Services\UserServices\UsersAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UploadController extends BaseApiController
{
    /**
     * @var UploadService
     */
    protected $uploadService;

    /**
     * @var UploadRepository
     */
    protected $uploadRepository;

    /**
     * @var UsersAccountService
     */
    protected $usersAccountService;

    /**
     * @var ClientRepository
     */
    protected $clientRepository;

    /**
     * @var SettingsUploadsRepository
     */
    protected $settingsUploadsRepo;

    public function __construct(UploadRepository $repository, UploadService $uploadService,
        UsersAccountService $usersAccountService, SettingsUploadsRepository $settingsUploadsRepo,
        ClientRepository $clientRepository
        ) {
        $this->uploadRepository = $repository;
        $this->uploadService = $uploadService;
        $this->usersAccountService = $usersAccountService;
        $this->settingsUploadsRepo = $settingsUploadsRepo;
        $this->clientRepository = $clientRepository;
    }

    /**
     * Uploads an original image
     *
     * @param StoreUploadRequest $request
     * @param int $clientId
     * @param int $settingId
     * @param string $customName
     * @return mixed
     */
    public function uploadOriginal(StoreUploadRequest $request, int $clientId, int $settingId, string $customName = null)
    {
        $data = [
            'data' => $request->all(),
            'clientId' => $clientId,
            'settingId' => $settingId,
            'customName' => $customName,
        ];

        $genericUploadService = new GenericUpload($data, auth()->user());
        $result = $genericUploadService->process();
        if (!$result['error']) {
            return $result['data'];
        }

        if ($result['error'] instanceof NoPermissionException) {
            throw $result['error'];
        }

        return response()->json($result['error']);
    }

    /**
     * Uploads shrinked images
     *
     * @param Request $request
     * @param int $clientId
     * @param int $settingId
     * @param string $uuid
     * @return mixed
     */
    public function uploadFiles(Request $request, int $clientId, int $settingId, string $uuid)
    {
        $data = $request->all();
        $settings = $this->settingsUploadsRepo->find($settingId, false);

        if ($this->usersAccountService->checkIfUserHasPermissionByClientId(auth()->user(), $clientId, 'create upload') ||
            $this->usersAccountService->checkIfUserIsSoftwareowner(auth()->user(), $clientId) ||
            $this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {

            if ($settings) {
                // Set up variables
                // TODO: error here
                $uuid = $upload->uuid;
                $file = $data['filepond'];
                $extension = $file->clientExtension();

                // Get file patch
                // TODO: error here
                $path = $this->uploadService->getPath($uuid, $extension, $setting->model, $setting->model_id);

                // Store file in temp
                $tempPath = $this->uploadService->storeFileInTemp($file, 'tmp/' . $uuid);

                // Convert file to WebP
                $webpFile = $this->uploadService->imageToWebp($tempPath, $settings);

                // Upload file to S3
                $uploadSuccess = $this->uploadService->storeFileInAws($webpFile, $path);

                // Clear temp
                $this->uploadService->removeFilesFromTemp($tempPath);
            }
        }
        return $uploadSuccess;
    }

    /**
     * Deletes images
     *
     * @param Request $request
     * @param string $uuid
     * @return mixed
     */
    public function delete(Request $request, string $uuid)
    {
        if ($this->usersAccountService->checkIfUserHasPermissionByClientId(auth()->user(), $clientId, 'create upload') || $this->usersAccountService->checkIfUserIsSoftwareowner(auth()->user(), $clientId) || $this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
            $upload = Upload::where('uuid', $uuid)->first();

            $path = $this->uploadService->getPath($upload->model, $upload->model_id);

            if ($this->uploadService->removeFilesFromAws($path)) {
                return response()->json(['message' => 'Success.'], 200);
            }
        }
        throw new NoPermissionException;
    }
}
