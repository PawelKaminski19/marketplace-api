<?php

namespace App\Services\SignupServices;

use Carbon\Carbon;
use App\Models\Guest;
use App\Repositories\GuestRepository;
use App\Services\DomainServices\DomainService;
use Session;
use Uuid;

/**
 * Class VerifyEmailService.
 *
 * @package App\Services\VerifyEmailService
 */
class VerifyEmailService
{

    /**
     * Create a new VerifyEmailService instance.
     * @return void
     */
    public function __construct()
    {
        $this->guestRepository = app()->make(GuestRepository::class);
        $this->domainService = app()->make(DomainService::class);
    }
}
