<?php

namespace App\Services\WebsiteServices;

use App\Repositories\CountryRepository;
use App\Repositories\GuestRepository;
use App\Repositories\WebsiteRepository;

/**
 * Class WebsiteService.
 *
 * @package App\Services\WebsiteServices
 */
class WebsiteService
{

    /**
     * Create a new WebsiteService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->guestRepository = app()->make(GuestRepository::class);
        $this->websiteRepository = app()->make(WebsiteRepository::class);
        $this->countryRepository = app()->make(CountryRepository::class);
    }

    /**
     * Get Website by id
     *
     * @param int $id
     * @return string
     */
    public function getById(int $id)
    {
        return $this->websiteRepository->find($id, false);
    }

    /**
     * Get Website by id and client Id
     *
     * @param int $id
     * @param int $clientId
     * @return string
     */
    public function getByIdAndClient(int $id, int $clientId)
    {
        return $this->websiteRepository->findByClient($id, $clientId);
    }

    public static function slug($string)
    {
        $string = str_replace(['.'], '-', $string);
        $string = mb_strtolower($string);
        return $string;
    }

}
