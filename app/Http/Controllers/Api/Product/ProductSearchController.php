<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Requests\ProductsRequests\StoreProductRequest;
use App\Http\Requests\ProductsRequests\UpdateProductRequest;
use App\Models\WebsitesProduct;
use App\Repositories\ProductRepository;
use App\Http\Controllers\Api\BaseApiController;
use App\Services\ProductServices\WebsitesProductService;
use Illuminate\Http\Request;
use App\Http\Requests\BaseFormForSoOnly;

class ProductSearchController extends BaseApiController
{
    /** @var ProductRepository */
    private $productRepo;

    /** @var WebsitesProductService */
    private $websitesProductService;

    /**
     * ProductSearchController constructor.
     *
     * @param ProductRepository $productRepo
     * @param WebsitesProductService $websitesProductService
     */
    public function __construct(ProductRepository $productRepo, WebsitesProductService $websitesProductService)
    {
        $this->productRepo = $productRepo;
        $this->websitesProductService = $websitesProductService;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getByUrlAndWebsite(Request $request)
    {
        $data = $request->all();
        $locale = $data['locale'];
        $url = $data['url'];
        $websiteId = $data['website_id'];

        /**
         * @var WebsitesProduct $products
         */
        $products = $this->websitesProductService->getByUrl($locale, $url, $websiteId);
        if ($products) {
            $products->load([
                'website', 'client', 'category', 'product', 'websitesProductsMeta', 'brand', 'product.uploads',
                'variants', 'variants.variant_group'
            ]);
            $products->setAttribute('shops', $products->shops());
        }

        return $products ? response()->json($products) : response()->json(['error' => 'Product not found.']);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getByWebsiteAndCategory(Request $request)
    {
        $data = $request->all();
        $websiteId = $data['website_id'];
        $categoryId = $data['category_id'];

        $products = $this->websitesProductService->getByCategory($categoryId, $websiteId);
        return $products ? $products->load('product', 'websitesProductsMeta', 'brand') : response()->json(["error" => "Product not found."]);
    }


    /**
     * @param int $websiteId
     * @param bool|null $active
     * @return mixed
     */
    public function getByWebsite(int $websiteId, bool $active = null)
    {
        $products = $this->websitesProductService->getByWebsiteId($websiteId,true);
        if ($products) {
            $products->load([
                'website', 'client', 'category', 'product', 'websitesProductsMeta', 'brand', 'product.uploads',
                'variants', 'variants.variant_group'
            ]);
            return response()->json($products);
        }
        return response()->json(['error' => 'Product not found.']);
    }


    /**
     * @param bool|null $active
     * @return mixed
     */
    public function getAll(BaseFormForSoOnly $request, bool $active = null)
    {
        $products = $this->productRepo->getAll(true);
        if ($products) {
            $products->load([
                'brand','category','secondaryCategories', 'uploads',
                'variantsCombinations', 'tags'
            ]);
            return response()->json($products);
        }
        return response()->json(['error' => 'Product not found.']);
    }

    /**
     * @param int $brandId
     * @param int|null $websiteId
     * @param bool|null $active
     * @return mixed
     */
    public function getByBrand(int $brandId, int $websiteId = null, bool $active = null)
    {
        return $this->productRepo->getProductsByBrand($brandId, $websiteId, $active)->toArray();
    }

    /**
     * @param int $categoryId
     * @param int|null $websiteId
     * @param bool|null $active
     * @return mixed
     */
    public function getByCategory(int $categoryId, int $websiteId = null, bool $active = null)
    {
        return $this->productRepo->getProductsByCategory($categoryId, $websiteId, $active)->toArray();
    }

    /**
     * @param string $name
     * @param int|null $websiteId
     * @param bool|null $active
     * @return mixed
     */
    public function getByName(string $name, int $websiteId = null, bool $active = null)
    {
        $product = $this->productRepo->getProductByName($name, $websiteId, $active);

        if ($product) {
            return $product->toArray();
        } else {
            return "false";
        }
    }

    /**
     * @param float $price
     * @param int|null $websiteId
     * @param bool|null $showPrice
     * @param bool|null $active
     * @return mixed
     */
    public function getByPrice(float $price, int $websiteId = null, bool $showPrice = null, bool $active = null)
    {
        return $this->productRepo->getProductsByPrice($price, $websiteId, $showPrice, $active)->toArray();
    }

    /**
     * @param float|null $minPrice
     * @param float|null $maxPrice
     * @param bool|null $showPrice
     * @param bool|null $active
     * @return mixed
     */
    public function getByPriceRange(float $minPrice = null, float $maxPrice = null, bool $showPrice = null, bool $active = null)
    {
        return $this->productRepo->getProductsByPriceRange($minPrice, $maxPrice, $showPrice, $active)->toArray();
    }

    /**
     * @param string $ean
     * @param int|null $websiteId
     * @param bool|null $active
     * @return mixed
     */
    public function getByEan(string $ean, int $websiteId = null, bool $active = null)
    {
        return $this->productRepo->getProductByEan($ean, $websiteId, $active)->toArray();
    }
}
