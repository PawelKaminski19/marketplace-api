<?php

namespace App\Services\LocationServices;

use Carbon\Carbon;
use App\Models\Client;
use App\Repositories\CountryRepository;
use App\Repositories\GuestRepository;
use App\Repositories\LocationRepository;
use App\Services\DomainServices\DomainService;
use Session;
use Uuid;

/**
 * Class LocationService.
 *
 * @package App\Services\GuestServices
 */
class LocationService
{

    /**
     * Create a new VerifyEmailService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->guestRepository = app()->make(GuestRepository::class);
        $this->locationRepository = app()->make(LocationRepository::class);
        $this->countryRepository = app()->make(CountryRepository::class);
    }

    public function create($data)
    {
        return $this->locationRepository->create(array_merge($data, ["active" => 1]));
    }
}
