<?php
namespace App\Services\SignupSellersAccountServices;

use Carbon\Carbon;
use App\Models\Guest;
use App\Repositories\CompanyPrimaryContactRepository;
use App\Services\DomainServices\DomainService;
use Session;
use Uuid;

/**
 * Class CompanyPrimaryContactsService.
 *
 * @package App\Services\CompanyPrimaryContactsServices\CompanyPrimaryContactsService
 */
class CompanyPrimaryContactsService
{
    /**
    * @var CompanyPrimaryContactRepository
     */
    protected $companyPrimaryContactRepository;

    /**
     * Create a new CompanyPrimaryContactsService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->companyPrimaryContactRepository = app()->make(CompanyPrimaryContactRepository::class);
    }

    /**
     * Creates new ComparyPrimaryContact
     *
     * @param array data
     * @return ComparyPrimaryContact
     */
    public function create($data)
    {
        return $this->companyPrimaryContactRepository->create(array_merge($data, ["active" => 1]));
    }
}
