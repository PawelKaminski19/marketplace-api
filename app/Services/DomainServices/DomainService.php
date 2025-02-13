<?php

namespace App\Services\DomainServices;

use Carbon\Carbon;
use App\Models\User;
use App\Repositories\DomainRepository;

/**
 * Class DomainService.
 *
 * @package App\Services\DomainServices
 */
class DomainService
{
    /**
    * @var DomainRepository
     */
    protected $domainRepository;

    /**
     * Create a new DomainService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->domainRepository = app()->make(DomainRepository::class);
    }

    /**
     * Cleans the url
     *
     * @param string url
     * @return string $url
     */
    public function clearUrl(string $url)
    {
        $result = parse_url($url);
        if (isset($result['scheme'])) {
            return preg_replace('#^www\.(.+\.)#i', '$1', $result['host']);
        }
        elseif (isset($result['path'])) {
            return preg_replace('#^www\.(.+\.)#i', '$1', $result['path']);
        }

        return preg_replace('#^www\.(.+\.)#i', '$1', $result['host']);
    }
    /**
     * Get the all domains
     *
     * @return array
     */
    public function getAll()
    {
        return $this->domainRepository->getAll();
    }

    /**
     * Get by domain.
     *
     * @param string $domain
     * @return Model
     */
    public function findByDomain(string $domain)
    {
        // !!this should be updated!!
        // sysem should collect ALL of the domains, save it into cache
        // then the findByDomain should search against the whole collection
        // rather then hitting the database
        return $this->domainRepository->findByDomain($this->clearUrl($domain));

    }
}
