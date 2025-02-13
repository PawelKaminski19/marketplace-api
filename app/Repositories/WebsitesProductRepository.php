<?php

namespace App\Repositories;

use App\Models\WebsitesProduct;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class WebsitesProductRepository.
 *
 * @package App\Repository
 */
class WebsitesProductRepository extends BaseRepository
{
    /**
     * Initialize Website repository instance.
     *
     * @param WebsitesProduct $model
     */
    public function __construct(WebsitesProduct $model)
    {
        $this->model = $model;
    }

    /**
     * Query by Url
     *
     * @param string $locale
     * @param string $url
     * @return WebsitesProduct
     */
    public function queryByUrl(string $locale, string $url, int $websiteId = null)
    {
        $product = $this->model->whereTranslation('url', $url, $locale);
        $product = $this->queryByWebsite($product, $websiteId);
        return $product->first();
    }

    /**
     * Query by Website ID
     *
     * @param Builder $product
     * @param int $websiteId
     * @return WebsitesProduct
     */
    public function queryByWebsiteId(int $websiteId, bool $paginate = false)
    {
        $product = $this->model->query();
        $product = $this->queryByWebsite($product, $websiteId);
        return $paginate ? $product->paginate() : $product->get();
    }

    /**
     * Get all products by category ID.
     *
     * @param int $categoryId
     * @param int|null $websiteId
     * @return mixed
     */
    public function queryByCategoryId(int $categoryId, int $websiteId = null)
    {
        $product = $this->model->where('category_id', $categoryId);
        $product = $this->queryByWebsite($product, $websiteId);
        return $product->get();
    }

    /**
     * Query by Website
     *
     * @param Builder $product
     * @param int $websiteId
     * @return WebsitesProduct
     */
    private function queryByWebsite(Builder $product, int $websiteId = null)
    {
        if ($websiteId) {
            return $product->where('website_id', '=', $websiteId);
        } else {
            return $product;
        }
    }
}
