<?php
namespace App\Services\CountryServices;

use App\Repositories\CountryRepository;

/**
 * Class CountryService.
 *
 * @package App\Services\GuestServices
 */
class CountryService
{

    /**
     * Create a new CountryService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->countryRepository = app()->make(CountryRepository::class);
    }

    /**
     * Finds Country by ISO
     *
     * @param string $country_iso
     * @return Country
     */
    public function findByIso(string $country_iso)
    {
        return $this->countryRepository->findByIso($country_iso);
    }

    /**
     * Finds All Countries
     *
     * @return Collection
     */
    public function getAll()
    {
        return $this->countryRepository->getAll();
    }

    /**
     * Finds Country by id
     *
     * @param int $country
     * @return Country
     */
    public function find(int $country)
    {
        return $this->countryRepository->find($country);
    }
}
