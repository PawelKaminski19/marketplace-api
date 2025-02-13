<?php

namespace App\Services\SettingServices;

use Carbon\Carbon;
use App\Models\User;
use App\Repositories\SettingsUploadsRepository;

/**
 * Class SettingsUploadsService.
 *
 * @package App\Services\SettingsUploadsServices
 */
class SettingsUploadsService
{
    /**
    * @var SettingsUploadsRepository
     */
    protected $settingsUploadsRepo;

    /**
     * Create a new SettingsUploadsService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->settingsUploadsRepo = app()->make(SettingsUploadsRepository::class);
    }


    /**
     * Get the settingsuploads by client id, website, model and type
     *
     * @param int $clientId
     * @param int $websiteId
     * @param string $model
     * @param string $type
     * @return array
     */
    public function getSettingByClientWebsiteModelType(int $clientId, ?int $websiteId, ?string $model, ?string $type)
    {
        $coreSettingsUploads = $this->settingsUploadsRepo->getAllCore()->toArray();
        $settings = $this->settingsUploadsRepo->getByClientWebsiteModelType($clientId, $websiteId, $model,$type)->toArray();

        foreach ($settings as $arr) {
            foreach ($coreSettingsUploads as $k => $v) {
                if ($arr['model'] == $v['model'] && $arr['type'] == $v['type']) {
                    unset($coreSettingsUploads[$k]);
                }
            }
        }
        return array_merge($settings,$coreSettingsUploads);

    }
    /**
     * Get the all settings uploads
     *
     * @return array
     */
    public function getAll()
    {
        $settings = $this->settingsUploadsRepo->getAll();
        return $settings;
    }

    /**
     * Get the all settings uploads
     *
     * @return array
     */
    public function getAllCore()
    {
        $settings = $this->settingsUploadsRepo->getAllCore();
        return $settings;
    }
}
