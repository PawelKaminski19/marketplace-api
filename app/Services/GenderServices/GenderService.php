<?php
namespace App\Services\GenderServices;

use App\Repositories\GenderRepository;

/**
 * Class GenderService.
 *
 * @package App\Services\GenderServices
 */
class GenderService
{

    /**
     * Create a new GenderService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->genderRepository = app()->make(GenderRepository::class);
    }
    public function getAll()
    {
        return $this->genderRepository->getAll();
    }
}
