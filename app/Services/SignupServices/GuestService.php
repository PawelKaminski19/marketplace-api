<?php

namespace App\Services\SignupServices;

use App\Models\Guest;
use App\Repositories\GuestRepository;
use App\Services\DomainServices\DomainService;
use Carbon\Carbon;
use Session;
use Uuid;

/**
 * Class GuestService.
 *
 * @package App\Services\GuestServices
 */
class GuestService
{
    /**
     * @var GuestRepository
     */
    protected $guestRepository;

    /**
     * @var DomainService
     */
    protected $domainService;

    /**
     * Create a new GuestService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->guestRepository = app()->make(GuestRepository::class);
        $this->domainService = app()->make(DomainService::class);
    }
    /**
     * Update a guest by uuid
     *
     * @return array
     */
    public function updateByUuid(string $uuid, array $data)
    {
        return $this->guestRepository->updateByUuid($uuid, $data);
    }

    /**
     * Get the all guests
     *
     * @return array
     */
    public function getAll()
    {
        return $this->guestRepository->getAll();
    }

    /**
     * find by Uuid
     *
     * @param string $uuid
     * @return array
     */
    public function findByUuid(string $uuid)
    {
        return $this->guestRepository->findByUuid($uuid);
    }

    /**
     * find by email
     *
     * @param string $email
     * @return array
     */
    public function findByEmail(string $email)
    {
        return $this->guestRepository->findByEmail($email);
    }

    /**
     * find by Uuid
     *
     * @param string $uuid
     * @return array
     */
    public function findBySessionId(string $session)
    {
        return $this->guestRepository->findBySessionId($session);
    }

    /**
     * create guest record
     *
     * @param array $data
     * @return Model
     */
    public function createInitialVisit(array $data)
    {
        /** @var Session $session */
        $session = Session::getId();

        /** @var string $uuid */
        $uuid = Uuid::generate(4);

        /**
         * @var array $additionalData
         */
        $additionalData = [];

        if (isset($data['domain'])) {
            $domainObj = $this->domainService->findByDomain($data['domain']);
            if ($domainObj) {
                $additionalData["domain_id"] = $domainObj->id;
                $additionalData["website_id"] = $domainObj->website_id;
            }
        }
        $additionalData["uuid"] = $uuid->string;
        $additionalData["session"] = $session;

        return $this->guestRepository->create(array_merge($data, $additionalData));
    }

    /**
     * update Email Verification Status
     *
     * @param int $modelId
     * @param boolean $activated
     *
     * @return Model
     */
    public function updateEmailVerificationStatus(int $modelId, int $activated = 1)
    {
        return $this->guestRepository->update($modelId, ["email_is_verified" => $activated,
            "email_is_verified_at" => Carbon::now(),
        ]);
    }

    /**
     * Update given Guest
     *
     * @param int $id
     * @param array data
     * @return Guest
     */
    public function update(int $id, array $data)
    {
        return $this->guestRepository->update($id, $data);
    }
}
