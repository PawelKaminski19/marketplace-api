<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Requests\ProductRequests\StoreProductRequest;
use App\Http\Requests\ProductsRequests\UpdateProductRequest;
use App\Repositories\ProductRepository;
use App\Http\Controllers\Api\BaseApiController;
use App\Services\ProductServices\ProductService;
use App\Services\ProductServices\WebsitesProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends BaseApiController
{
    /**
     * @var ProductRepository
     */
    private $productRepo;

    /**
     * @var WebsitesProductService
     */
    private $websitesProductService;
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * ProductController constructor.
     * @param ProductRepository $productRepo
     * @param WebsitesProductService $websitesProductService
     * @param ProductService $productService
     */
    public function __construct(ProductRepository $productRepo, WebsitesProductService $websitesProductService, ProductService $productService)
    {
        parent::__construct();

        $this->productRepo = $productRepo;
        $this->websitesProductService = $websitesProductService;
        $this->productService = $productService;
    }

    /**
     * @param StoreProductRequest $request
     * @return JsonResponse
     */
    public function storeProduct(StoreProductRequest $request)
    {
        try {
            $data = $request->all();

            $product = $this->productService->storeProduct($data);

            return response()->json([
                'product' => $product
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => true,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * @param UpdateProductRequest $request
     * @param int $id
     * @return mixed
     */
    public function updateProduct(UpdateProductRequest $request, int $id)
    {
        $data = $request->all();

        $product = $this->productService->updateProduct($id, $data);

        return response()->json([
            'product' => $product->load(['tags', 'category', 'secondaryCategories'])
        ]);
    }

    /**
     * @param int $id
     * @return array
     */
    public function showProduct(int $id)
    {
        return $this->productRepo->find($id, true)->toArray();
    }

    /**
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public function deleteProduct(int $id)
    {
        if ($this->productRepo->find($id)->delete()) {
            return "true";
        } else {
            return "false";
        }
    }

}
