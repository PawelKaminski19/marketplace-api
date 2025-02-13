<?php
namespace App\Services\ProductServices;

use App\Repositories\WebsitesProductRepository;

/**
 * Class WebsitesProductService.
 *
 * @package App\Services\WebsitesProductService
 */
class WebsitesProductService
{
    /**
     * Create a new WebsitesProductService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->websitesProductRepository = app()->make(WebsitesProductRepository::class);
    }

    public function getAll()
    {
        return $this->websitesProductRepository->getAll();
    }
    /**
     * @param int|null $websiteId
     * @param bool $paginate
     * @return mixed
     */
    public function getByWebsiteId(int $websiteId, bool $paginate = false)
    {
        return $this->websitesProductRepository->queryByWebsiteId($websiteId, $paginate);
    }

    /**
     * @param string $locale
     * @param string $url
     * @param int|null $websiteId
     * @return mixed
     */
    public function getByUrl(string $locale, string $url, int $websiteId = null)
    {
        return $this->websitesProductRepository->queryByUrl($locale, $url, $websiteId);
    }
    
    /**
     * @param string $categoryId
     * @param int|null $websiteId
     * @return mixed
     */
    public function getByCategory(int $categoryId, int $websiteId = null)
    {
        return $this->websitesProductRepository->queryByCategoryId($categoryId, $websiteId);
    }
}
