<?php

namespace App\Services\ProductServices;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class ProductService.
 *
 * @package App\Services\GenderServices
 */
class ProductService
{
    private $productRepository;

    /**
     * Product data sent from the controller
     * @var $data
     */
    private $data;

    /**
     * @var
     */

    private $combinationService;

    /**
     * Create a new ProductService instance.
     *
     * @param CombinationService $combinationService
     * @throws BindingResolutionException
     */
    public function __construct(CombinationService $combinationService)
    {
        $this->productRepository = app()->make(ProductRepository::class);
        $this->combinationService = $combinationService;
    }

    public function getAll()
    {
        return $this->productRepository->getAll();
    }

    /**
     * @param string $url
     * @return mixed
     */
    public function getByUrl(string $url)
    {
        return $this->productRepository->queryByUrl($url);
    }

    /**
     * Manage request data and store product and its relations
     * @param array $data
     * @return mixed
     */
    public function storeProduct(array $data)
    {
        $this->manageData($data);

        $product = $this->saveProduct();
        $this->updateProduct($product->id, $data);

        if (array_key_exists('combinations', $data)) {
            $this->combinationService->storeCombinations($product->id);
        }

        return $product;
    }

    /**
     * Manage request data and update products
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateProduct(int $id, array $data)
    {
        $this->manageData($data);

        return $this->saveChanges($id);
    }

    /**
     * Set request data
     * @param $data
     */
    private function setData($data)
    {
        $this->data = $data;
    }

    /**
     * Save a product to database
     * @return mixed
     */
    private function saveProduct()
    {
        return $this->productRepository->create($this->data);
    }

    /**
     * Sets the data and extracts any relations from request
     * @param array $data
     */
    private function manageData(array $data): void
    {
        if (!array_key_exists('meta_title', $data)) {
            $data['meta_title'] = $data['name'];
        }
        if (!array_key_exists('meta_description', $data)) {
            if (isset($data['description_short'])) {
                $data['meta_description'] = $data['description_short'];
            }
            else {
                $data['meta_description'] = strip_tags($data['description']);
            }
        }
        if (!array_key_exists('meta_keywords', $data)) {
            $data['meta_keywords'] = $data['name'];
        }
        if (!isset($data['redirect_type']) || $data['redirect_type'] === null) {
            $data['redirect_type'] = '';
        }
        if (empty($data['url'])) {
            $data['url'] = \Str::slug($data['name']);
        }
        if (empty($data['description_short'])) {
            $data['description_short'] = strip_tags($data['description']);
        }

        $this->setData($data);

        if (array_key_exists('combinations', $this->data)) {
            $this->manageCombinations();
        }
    }

    /**
     * Save product changes to database
     * @param int $id
     * @return mixed
     */
    private function saveChanges(int $id)
    {
        /** @var Product $record */
        $product = $this->productRepository->update($id, $this->data);
        if ($this->data['secondary_categories']) {
            $product->secondaryCategories()->sync($this->data['secondary_categories']);
        }
        if ($this->data['tags']) {
            $product->tags()->sync($this->data['tags'], [
                'websites_product_id' => isset($this->data['websites_product_id']) ?
                    $this->data['websites_product_id'] : null
            ]);
        }

        return $product;
    }

    /**
     * Extract variant combinations data.
     * @return array
     */
    private function extractCombinationsData() : array
    {
        $combinations = $this->data['combinations'];

        unset($this->data['combinations']);

        return $combinations;
    }

    /**
     * Manage combination data before inserting to the database.
     */
    private function manageCombinations() : void
    {
        $combinations = $this->extractCombinationsData();

        $this->combinationService->manageCombinations($combinations);
    }

}
