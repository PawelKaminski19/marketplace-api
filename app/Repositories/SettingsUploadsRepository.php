<?php
namespace App\Repositories;

use App\Models\SettingsUpload;

/**
 * Class SettingsUploadsRepository.
 *
 * @package App\Repository
 */
class SettingsUploadsRepository extends BaseRepository
{
    protected $model;

    /**
     * Initialize clients repository instance.
     *
     * @param SettingsUpload $model
     */
    public function __construct(SettingsUpload $model)
    {
        $this->model = $model;
    }

    /**
     * Get All Core SettingsUploads
     *
     * @return Collection
     */
    public function getAllCore()
    {
        return $this->model->where('core', '=', 1)->get();
    }

    /**
     * Get SettingsUploads by client ID
     *
     * @param int $clientId
     * @return Collection
     */
    public function getSettingByClient(int $clientId)
    {
        return $this->model->where('client_id', '=', $clientId)->get();
    }

    /**
     * Get SettingsUploads by client ID, website Id, model and type
     *
     * @param int $clientId
     * @param int $websiteId
     * @param int $model
     * @param int $type
     * @return Collection
     */
    public function getByClientWebsiteModelType(int $clientId, ?int $websiteId, ?string $model, ?string $type)
    {
        $q = $this->model->where('client_id', '=', $clientId);

        if (!empty($websiteId)) {
            $q->where('website_id', '=', $websiteId);
        }
        if (!empty($model)) {
            $q->where('model', '=', $model);
        }
        if (!empty($type)) {
            $q->where('type', '=', $type);
        }
        return $q->get();
    }

    /**
     * Get SettingsUploads by client ID and setting Id
     *
     * @param int $clientId
     * @param int $settingId
     * @return Collection
     */
    public function findByClientAndId(int $clientId, int $settingId)
    {
        return $this->model->where('client_id', '=', $clientId)->where('id', '=', $settingId)->first();
    }
}
