<?php
namespace App\Services\UploadServices;

use App\Exceptions\NoPermissionException;
use App\Models\Client;
use App\Models\Setting;
use App\Models\User;
use App\Repositories\ClientRepository;
use App\Repositories\SettingsUploadsRepository;
use App\Repositories\UploadRepository;
use App\Services\UserServices\UsersAccountService;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use WebPConvert\WebPConvert;

class GenericUpload
{
    /** @var array */
    protected $data;

    /** @var User */
    protected $user;

    /** @var UploadRepository */
    protected $uploadRepository;

    /** @var UploadService */
    protected $uploadService;

    /** @var UsersAccountService */
    protected $usersAccountService;

    /** @var SettingsUploadsRepository */
    protected $settingsUploadsRepo;

    /** @var ClientRepository */
    protected $clientRepository;

    public function __construct($data, User $user = null)
    {
        $this->data = $data;
        $this->user = $user;

        $this->uploadRepository = app()->make(UploadRepository::class);
        $this->uploadService = app()->make(UploadService::class);
        $this->usersAccountService = app()->make(UsersAccountService::class);
        $this->settingsUploadsRepo = app()->make(SettingsUploadsRepository::class);
        $this->clientRepository = app()->make(ClientRepository::class);
    }

    /**
     * Process the request.
     *
     * @return array
     */
    public function process()
    {
        $data = $this->data['data'];
        $clientId = $this->data['clientId'];
        $settingId = $this->data['settingId'];

        $setting = $this->settingsUploadsRepo->find($settingId, false);

        if ($setting) {
            $uuid = Str::uuid()->toString();
            /** @var UploadedFile $file */
            $file = $data['filepond'];
            $name = $file->getClientOriginalName();
            $size = $file->getSize();
            $extension = $file->clientExtension();

            if ($extension == 'bin') {
                // seeder probably - check an extension manually
                $t = explode('.', $file->getFilename());
                $extension = end($t);
            }

            \DB::beginTransaction();

            $upload = $this->uploadRepository->create([
                'uuid' => $uuid,
                'client_id' => $clientId,
                'website_id' => $setting->website_id ?? null,
                'user_id' => $this->user->id,
                'model' => $setting->model,
                'model_id' => $data['model']->id,
                'type' => $setting->type,
                'title' => $customName ?? null,
                'name' => $name,
                'size' => $size,
                'dimensions' => '{}',
                'extension' => $extension,
                'md5' => md5($uuid.'.'.$extension),
                'complete' => 0
            ]);

            // Get file patch
            $path = $this->uploadService->getPath($setting->model, $data['model']->id);

            // Upload file to S3
            if ($uploadSuccess = $this->uploadService->storeFileInAws($file, $path, $uuid . '.' . $extension)) {
                $this->uploadRepository->update($upload->id, ['complete' => 1]);
                \DB::commit();
            }
            else {
                \DB::rollback();
                return [
                    'error' => 'Upload failed',
                ];
            }

            return [
                'error' => null,
                'data' => Crypt::encryptString($uuid),
                'storage' => $uploadSuccess
            ];
        }

        return [
            'error' => 'Bad setting id.'
        ];
    }
}
