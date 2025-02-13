<?php

namespace App\Services\CategoryServices;

use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CategoryService
{
    /** @var CategoryRepository */
    private $categoryRepository;

    /**
     * Create a new CompanyService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categoryRepository = app()->make(CategoryRepository::class);
    }

    /**
     * @param array $attributes
     * @return Category
     */
    public function storeCategory(array $attributes)
    {
        return $this->categoryRepository->create($attributes);
    }

    /**
    * @param array $attributes
    * @return Category
    */
    public function updateCategory(array $attributes, int $id)
    {
        return $this->categoryRepository->update($id, $attributes);
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function showCategory(int $id)
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * @param int $id
     * @return string
     */
    public function deleteCategory(int $id)
    {
        if ($this->categoryRepository->delete($id)) {
            return "true";
        }

        return "false";
    }


    /**
     * @param int $categoryId
     * @return mixed
     */
    public function getRootCategory(int $categoryId)
    {
        $category = $this->categoryRepository->getRootByCategory($categoryId);

        return $category;
    }

    /**
     * @param int $categoryId
     * @return mixed
     */
    public function getChildrenCategories(int $categoryId)
    {
        $categories = $this->categoryRepository->getChildrenByCategory($categoryId);

        return $categories;
    }

    /**
     * @param int $categoryId
     * @param int $position
     * @param int|null $parentId
     * @return mixed
     */
    public function changePosition(int $categoryId, int $position, int $parentId = null)
    {
        $category = $this->categoryRepository->changePosition($categoryId, $position, $parentId);

        return $category;
    }

    /**
     * Get all categories.
     *
     * @param null|int $websiteId
     * @params array $filters
     * @return Collection
     */
    public function tree($websiteId, $filters)
    {
        return $this->categoryRepository->tree($websiteId, $filters);
    }
}
