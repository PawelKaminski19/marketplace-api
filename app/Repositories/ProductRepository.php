<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository extends BaseRepository
{
    /**
     * Initialize repository instance.
     *
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    /**
     * Get Products by Client
     *
     * @param int $clientId
     * @param int|null $websiteId
     * @param bool|null $active
     * @return mixed
     */
    public function getProductsByClient(int $clientId, int $websiteId = null, bool $active = null)
    {
        $products = $this->model->where('client_id', '=', $clientId);
        $products = $this->queryByWebsite($products, $websiteId);
        $products = $this->queryByActive($products, $active);

        return $products->get();
    }

    /**
     * Get Products by Website
     *
     * @param int $websiteId
     * @param bool|null $active
     * @return mixed
     */
    public function getProductsByWebsite(int $websiteId, bool $active = null)
    {
        $products = $this->model->where('website_id', '=', $websiteId);
        $products = $this->queryByActive($products, $active);

        return $products->get();
    }

    /**
     * Get Products by Brand
     *
     * @param int $brandId
     * @param int|null $websiteId
     * @param bool|null $active
     * @return mixed
     */
    public function getProductsByBrand(int $brandId, int $websiteId = null, bool $active = null)
    {
        $products = $this->model->where('brand_id', '=', $brandId);
        $products = $this->queryByWebsite($products, $websiteId);
        $products = $this->queryByActive($products, $active);

        return $products->get();
    }

    /**
     * Get Product by Category
     *
     * @param int $categoryId
     * @param int|null $websiteId
     * @param bool|null $active
     * @return mixed
     */
    public function getProductsByCategory(int $categoryId, int $websiteId = null, bool $active = null)
    {
        $products = $this->model->where('category_id', '=', $categoryId);
        $products = $this->queryByWebsite($products, $websiteId);
        $products = $this->queryByActive($products, $active);

        return $products->get();
    }

    /**
     * Get Product by name
     *
     * @param string $name
     * @param int|null $websiteId
     * @param bool|null $active
     * @return mixed
     */
    public function getProductByName(string $name, int $websiteId = null, bool $active = null)
    {
        $product = $this->model->where('name', '=', $name);
        $product = $this->queryByWebsite($product, $websiteId);
        $product = $this->queryByActive($product, $active);

        return $product->first();
    }

    /**
     * Get Products by Price
     *
     * @param float $price
     * @param int|null $websiteId
     * @param bool|null $showPrice
     * @param bool|null $active
     * @return mixed
     */
    public function getProductsByPrice(
        float $price,
        int $websiteId = null,
        bool $showPrice = null,
        bool $active = null
    ) {
        $products = $this->model->where('price', '=', $price);
        $products = $this->queryByWebsite($products, $websiteId);
        $products = $this->queryByShowPrice($products, $showPrice);
        $products = $this->queryByActive($products, $active);

        return $products->get();
    }

    /**
     * Get Products by Price Range
     *
     * @param float|null $minPrice
     * @param float|null $maxPrice
     * @param bool|null $showPrice
     * @param bool|null $active
     * @return mixed
     */
    public function getProductsByPriceRange(
        float $minPrice = null,
        float $maxPrice = null,
        bool $showPrice = null,
        bool $active = null
    ) {
        if ($minPrice === null) {
            $minPrice = 0.0;
        }

        $products = $this->model->where('price', '>=', $minPrice);

        if ($maxPrice !== null && $maxPrice > 0.0) {
            $products = $products->where('price', '<=', $maxPrice);
        }

        $products = $this->queryByShowPrice($products, $showPrice);
        $products = $this->queryByActive($products, $active);

        return $products->get();
    }

    /**
     * Get Product By EAN-13
     *
     * @param string $ean
     * @param int|null $websiteId
     * @param bool|null $active
     * @return mixed
     */
    public function getProductByEan(string $ean, int $websiteId = null, bool $active = null)
    {
        $product = $this->model->where('ean13', '=', $ean);
        $product = $this->queryByWebsite($product, $websiteId);
        $product = $this->queryByActive($product, $active);

        return $product->first();
    }

    /**
     * Get Product By EAN-13
     *
     * @param string $isbn
     * @param int|null $websiteId
     * @param bool|null $active
     * @return mixed
     */
    public function getProductByIsbn(string $isbn, int $websiteId = null, bool $active = null)
    {
        $product = $this->model->where('isbn', '=', $isbn);
        $product = $this->queryByWebsite($product, $websiteId);
        $product = $this->queryByActive($product, $active);

        return $product->first();
    }

    /**
     * Get Product By UPC
     *
     * @param string $upc
     * @param int|null $websiteId
     * @param bool|null $active
     * @return mixed
     */
    public function getProductByUpc(string $upc, int $websiteId = null, bool $active = null)
    {
        $product = $this->model->where('isbn', '=', $upc);
        $product = $this->queryByWebsite($product, $websiteId);
        $product = $this->queryByActive($product, $active);

        return $product->first();
    }


    /**
     * Query by Website
     *
     * @param Product $product
     * @param int $websiteId
     * @return Product
     */
    private function queryByWebsite(Builder $product, int $websiteId = null)
    {
        if ($websiteId) {
            return $product->where('website_id', '=', $websiteId);
        } else {
            return $product;
        }
    }

    /**
     * Query by Url
     *
     * @param string $url
     * @return Product
     */
    public function queryByUrl(string $url)
    {
        $product = $this->model->where('url', '=', $url)->first();
    }
    /**
     * Query only active products
     *
     * @param Product $product
     * @param bool $active
     * @return Product
     */
    private function queryByActive(Builder $product, bool $active = null)
    {
        if ($active !== null) {
            return $product->where('active', '=', $active);
        } else {
            return $product;
        }
    }

    /**
     * Query by show_price
     *
     * @param Product $product
     * @param bool $showPrice
     * @return Product
     */
    private function queryByShowPrice(Builder $product, bool $showPrice = null)
    {
        if ($showPrice !== null) {
            return $product->where('show_price', '=', $showPrice);
        } else {
            return $product;
        }
    }
}
