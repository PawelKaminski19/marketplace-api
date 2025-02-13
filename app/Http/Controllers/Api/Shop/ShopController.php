<?php

namespace App\Http\Controllers\Api\Shop;

use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\BrandRepository;
use App\Repositories\WebsiteRepository;
use Illuminate\Http\Request;

class ShopController extends BaseApiController
{
    /** @var WebsiteRepository */
    protected $websiteRepository;

    /** @var BrandRepository */
    protected $brandRepository;

    /**
     * @param WebsiteRepository $websiteRepository
     * @param BrandRepository $brandRepository
     */
    public function __construct(WebsiteRepository $websiteRepository, BrandRepository $brandRepository, Request $request)
    {
        $this->websiteRepository = $websiteRepository;
        $this->brandRepository = $brandRepository;

        parent::__construct();
    }

    public function getWebsites(Request $request)
    {
        if (!$this->soDomain) {
            return response()->json('Forbidden')->setStatusCode(401);
        }

        return $this->websiteRepository->all();
    }

    public function getBrands(int $websiteId = null)
    {
        if ($websiteId) {
            return $this->websiteRepository->getBrands($websiteId)->toArray();
        }

        return $this->brandRepository->getActiveBrands();
    }

    /**
     * @param string $slug
     * @return string
     */
    public function getBySlug(string $slug)
    {
        return $this->websiteRepository->getShopBySlug($slug);
    }
}
