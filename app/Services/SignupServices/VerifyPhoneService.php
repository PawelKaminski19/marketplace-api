<?php

namespace App\Services\SignupServices;

use App\Models\Guest;
use App\Repositories\GuestRepository;
use App\Services\DomainServices\DomainService;

/**
 * Class VerifyPhoneService.
 *
 * @package App\Services\VerifyPhoneService
 */
class VerifyPhoneService
{
    /** @var GuestRepository */
    protected $guestRepository;

    /** * @var DomainService */
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
}
