<?php
namespace App\Repositories;

use App\Models\Domain;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

/**
 * Class CustomerRepository.
 *
 * @package App\Repository
 */
class DomainRepository extends BaseRepository
{

    /**
     * Initialize domain repository instance.
     *
     * @param Domain $model
     */
    public function __construct(Domain $model)
    {
        $this->model = $model;
    }

    /**
     * Get by domain.
     *
     * @param string $domain
     *
     * @return Model
     */
    public function findByDomain(string $domain)
    {
        $domainObj = $this->model->where('url', $domain)->first();

        return $domainObj ?? null;
    }
}
