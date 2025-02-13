<?php

namespace App\Http\Controllers\Api\Brand;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\BrandsRequests\StoreBrandRequest;
use App\Http\Requests\BrandsRequests\UpdateBrandRequest;
use App\Repositories\BrandRepository;
use Illuminate\Http\Request;

class BrandsController extends BaseApiController
{
    /** @var BrandRepository */
    private $brandRepo;

    /**
     * BrandsController constructor.
     * @param BrandRepository $brandRepo
     */
    public function __construct(BrandRepository $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }

    /**
     * @param StoreBrandRequest $request
     * @return array
     */
    public function store(StoreBrandRequest $request)
    {
        $attributes = $request->validated();

        return $this->brandRepo->create($attributes)->toArray();
    }

    /**
     * @param UpdateBrandRequest $request
     * @param int $id
     * @return mixed
     */
    public function update(UpdateBrandRequest $request, int $id)
    {
        $attributes = $request->validated();

        return $this->brandRepo->update($id, $attributes)->toArray();
    }

    /**
     * @param int $id
     * @return array
     */
    public function show(int $id)
    {
        return $this->brandRepo->find($id)->load('products','websites','clients')->toArray();
    }

    /**
     * @param int $id
     * @return string
     */
    public function delete(int $id)
    {
         if ($this->brandRepo->delete($id))
         {
             return "true";
         } else {
             return "false";
         }
    }

    /**
     * @return bool
     */
    public function approve()
    {
        if (auth()->user()->hasRole('SuperAdmin')) {
            $id = request('id');

            return $this->brandRepo->approveBrand($id);
        }

        return false;
    }

    /**
     * @param string $name
     * @return string
     */
    public function getByName(string $name)
    {
        $brand = $this->brandRepo->getBrandByName($name);

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
    public function getBySlug(string $slug)
    {
       return $this->brandRepo->getBrandBySlug($slug);
    }

    public function getByActive(int $clientId = null)
    {
        return $this->brandRepo->getActiveBrands($clientId)->toArray();
    }

    public function getByActiveWebsite(int $websiteId)
    {
        return $this->brandRepo->getActiveBrandsByWebsite($websiteId)->toArray();
    }

    public function getByBrand(int $brandId)
    {
        return $this->brandRepo->getProductsByBrandId($brandId)->toArray();
    }
}
