<?php


namespace App\Repositories;

use App\Exceptions\NoPermissionException;
use App\Models\Brand;
use App\Models\Website;

class BrandRepository extends BaseRepository
{
    /**
     * BrandRepository constructor.
     * @param Brand $model
     */
    public function __construct(Brand $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getBrandByName(string $name)
    {
        $brand = $this->model->where('name', '=', $name)->first();

        if ($brand) {
            return $brand->toArray();
        } else {
            return "false";
        }
    }

    /**
     * @param string $slug
     * @return string
     */
    public function getBrandBySlug(string $slug)
    {
        $brand = $this->model->where('slug', '=', $slug)->first();

        if ($brand) {
            return $brand->toArray();
        } else {
            return "false";
        }
    }

    /**
     * @param int|null $clientId
     * @return mixed
     */
    public function getActiveBrands(int $clientId = null)
    {
        $brands = $this->model->where('active', '=', 1);

        if ($clientId) {
            $brands = $brands->where('client_id', '=', $clientId);
        }

        return $brands->get();
    }

    /**
     * Get all ative brands by websiteId.
     *
     * @param int $websiteId
     * @returen
     */
    public function getActiveBrandsByWebsite(int $websiteId)
    {

    }

    /**
     * @param int $brandId
     * @return mixed
     */
    public function getProductsByBrandId(int $brandId)
    {
        return $this->model->find($brandId)->products;
    }

    /**
     * Approve a brand
     *
     * @param int $brandId
     * @return bool
     */
    public function approveBrand(int $brandId)
    {
        return $this->model->find($brandId)->update(['approved' => 1]);
    }

    /**
     * Assign brand to a client
     *
     * @param int $brandId
     * @param int $clientId
     * @return string
     */
    public function assignBrandToClient(int $brandId, int $clientId)
    {
        $brand = $this->model->find($brandId);

        if ($brand) {
            if ($brand->approved && !auth()->user()->hasRole('Systemowner')) {
                throw new NoPermissionException();
            }

            $brand->clients()->attach($clientId);
            if ($brand->clients()->where('client_id', '=', $clientId)->first()) {
                return "true";
            } else {
                return "false";
            }
        }

        return "false";
    }

    /**
     * @param int $brandId
     * @param int $websiteId
     * @return string
     */
    public function assignBrandToWebsite(int $brandId, int $websiteId)
    {
        $brand = $this->model->find($brandId);
        $website = Website::find($websiteId);

        if ($brand && $website) {
            if ($brand->websites()->where('website_id', '=', $website->id)->first()) {
                return "false";
            } else {
                $brand->websites()->attach($website);

                return "true";
            }
        }

        return "false";
    }
}
