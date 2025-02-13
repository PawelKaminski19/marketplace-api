<?php

namespace App\Http\Controllers\Api\SettingsUploads;

use App\Http\Requests\SettingRequests\StoreSettingRequest;
use App\Http\Requests\SettingRequests\UpdateSettingRequest;
use App\Http\Requests\SettingRequests\UpdateCoreSettingRequest;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\SettingsUploadsRepository;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use App\Services\UserServices\UsersAccountService;
use App\Services\SettingServices\SettingsUploadsService;
use App\Http\Resources\SettingsUploads\SettingsUploadsCollectionResource;
use App\Exceptions\NoPermissionException;

class SettingsUploadsController extends BaseApiController
{
    /**
    * @var SettingsUploadsRepository
     */
    protected $settingsUploadsRepo;
    /**
    * @var UsersAccountService
     */
    protected $usersAccountService;
    /**
    * @var SettingsUploadsService
     */
    protected $settingsUploadsService;
    /**
    * @var ClientRepository
     */
    protected $clientRepository;
    /**
    * @var SettingsUploadsCollectionResource
     */
    protected $settingsUploadsCollectionResource;

    /**
     * Create a new SettingsController instance.
     *
     * @param SettingsUploadsService $settingsUploadsService
     * @param SettingService $settingService
     * @param UsersAccountService $usersAccountService
     * @param ClientRepository $clientRepository
     * @param SettingsUploadsCollectionResource $settingsUploadsCollectionResource
     * @return void
     */
    public function __construct(SettingsUploadsRepository $settingsUploadsRepo, UsersAccountService $usersAccountService, ClientRepository $clientRepository, SettingsUploadsService $settingsUploadsService, SettingsUploadsCollectionResource $settingsUploadsCollectionResource)
    {
        $this->settingsUploadsRepo = $settingsUploadsRepo;
        $this->usersAccountService = $usersAccountService;
        $this->settingsUploadsService = $settingsUploadsService;
        $this->clientRepository = $clientRepository;
        $this->settingsUploadsCollectionResource = $settingsUploadsCollectionResource;
    }

    /**
     * Display a listing of the settings
     */
    public function index()
    {
        if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
            $this->settingsUploadsCollectionResource->setData($this->settingsUploadsService->getAll()->toArray());
            return $this->settingsUploadsCollectionResource;
        }
        throw new NoPermissionException;
    }

    /**
      * Display a listing of the settings by given client id.
      *
      * @param  int $clientId
      * @param  int $websiteId
      * @param  string $model
      * @param  string $type
     */
    public function byClientWebsiteModelType(int $clientId, int $websiteId = null, string $model = null, string $type = null)
    {

        if ($this->usersAccountService->checkIfUserHasPermissionByClientId(auth()->user(), $clientId, 'read setting')  || 
        $this->usersAccountService->checkIfUserIsSoftwareowner(auth()->user(), $clientId) || 
        $this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
            $this->settingsUploadsCollectionResource->setData($this->settingsUploadsService->getSettingByClientWebsiteModelType($clientId, $websiteId, $model, $type));
            return $this->settingsUploadsCollectionResource;
        }
        throw new NoPermissionException;
    }

    /**
      * Store a SettingsUploads by ClientId
      *
      * @param  StoreSettingRequest $request
      * @param  int $clientId
     */
    public function storeByClient(StoreSettingRequest $request, int $clientId)
    {
        $data = array_merge($request->json()->all(), ["client_id" => $clientId]);
        $data["core"] = 0;
        $data["model"] = 'App\\Models\\' . $data["model"];

            $setting = $this->settingsUploadsRepo
                ->create($data);
            if ($setting) {
                $this->settingsUploadsCollectionResource->setData($this->settingsUploadsService->getSettingByClientWebsiteModelType($clientId, null, null, null));
                return $this->settingsUploadsCollectionResource;
            }
            return response()->json(['error' => 'Bad Request.'], 401);
        
    }

    /**
      * Store CORE SettingsUploads
      *
      * @param  StoreSettingRequest $request
     */
    public function storeCore(StoreSettingRequest $request)
    {
        $data = array_merge($request->json()->all());
        $data["core"] = 1;
        $data["model"] = 'App\\Models\\' . $data["model"];

        if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
            $setting = $this->settingsUploadsRepo->create($data);
            if ($setting) {
                $this->settingsUploadsCollectionResource->setData($this->settingsUploadsService->getAllCore()->toArray());
                return $this->settingsUploadsCollectionResource;
            }
            return response()->json(['error' => 'Bad Request.'], 401);
        }
        throw new NoPermissionException;
    }

    /**
      * Update a SettingsUploads by ClientId
      *
      * @param  StoreSettingRequest $request
      * @param  int $settingId
      * @param  int $clientId
     */
    public function updateByClient(UpdateSettingRequest $request, int $settingId, int $clientId)
    {
        $settingsUploads = $this->settingsUploadsRepo->findByClientAndId($clientId, $settingId);

        $data = array_merge($request->json()->all(), ["client_id" => $clientId]);
        $data["core"] = 0;
        $data["model"] = 'App\\Models\\' . $data["model"];

        if ($settingsUploads) {
                $setting = $this->settingsUploadsRepo->update($settingId, $data);

                if ($setting) {
                    $this->settingsUploadsCollectionResource->setData($this->settingsUploadsService->getSettingByClientWebsiteModelType($clientId, null, null, null));
                    return $this->settingsUploadsCollectionResource;
                }
                return response()->json(['error' => 'Bad Request.'], 401);
           
        } else {
            return response()->json(['error' => 'Wrong Client'], 401);
        }

        throw new NoPermissionException;
    }

    /**
      * Update a SettingsUploads by ClientId
      *
      * @param  StoreSettingRequest $request
      * @param  int $settingId
     */
    public function updateCore(UpdateCoreSettingRequest $request, int $settingId)
    {
        $data = $request->json()->all();
        $data["core"] = 1;

        if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
            $setting = $this->settingsUploadsRepo->update($settingId, $data);

            if ($setting) {
                $this->settingsUploadsCollectionResource->setData($this->settingsUploadsService->getAllCore()->toArray());
                return $this->settingsUploadsCollectionResource;
            }
            return response()->json(['error' => 'Bad Request.'], 401);
        }

        throw new NoPermissionException;
    }

    /**
      * Delete a SettingsUploads by ClientId
      *
      * @param  int $settingId
     */
    public function deleteCore(int $settingId)
    {
        if ($this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
            if ($this->settingsUploadsRepo->delete($settingId)) {
                $this->settingsUploadsCollectionResource->setData($this->settingsUploadsService->getSettingByClientWebsiteModelType($clientId, null, null, null));
                return $this->settingsUploadsCollectionResource;
            }
            return response()->json(['error' => 'Bad Request.'], 401);
        }
        throw new NoPermissionException;
    }
    /**
      * Delete a SettingsUploads by ClientId
      *
      * @param  int $settingId
      * @param  int $clientId
     */
    public function deleteByClient(int $settingId, int $clientId)
    {
        /*
         * @var client
         * */
        $client = $this->clientRepository->find($clientId, false);
        $settingsUploads = $this->settingsUploadsRepo->findByClientAndId($clientId, $settingId);

        if ($settingsUploads) {
            if ($this->usersAccountService->checkIfUserHasPermissionByClientId(auth()->user(), $clientId, 'update setting')  || 
            $this->usersAccountService->checkIfUserIsSoftwareowner(auth()->user(), $clientId) || 
            $this->usersAccountService->checkIfUserIsSystemowner(auth()->user())) {
                if ($this->settingsUploadsRepo->delete($settingId)) {
                    $this->settingsUploadsCollectionResource->setData($this->settingsUploadsService->getSettingByClientWebsiteModelType($clientId, null, null, null));
                    return $this->settingsUploadsCollectionResource;
                }
                return response()->json(['error' => 'Bad Request.'], 401);
            }
        } else {
            return response()->json(['error' => 'Wrong Client'], 401);
        }

        throw new NoPermissionException;
    }
}
