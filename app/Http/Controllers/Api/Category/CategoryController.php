<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Requests\CategoriesRequests\StoreCategoryRequest;
use App\Http\Requests\CategoriesRequests\TreeCategoryRequest;
use App\Http\Requests\CategoriesRequests\UpdateCategoryRequest;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\CategoryRepository;
use App\Services\CategoryServices\CategoryService;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResources\CategoryResource;

class CategoryController extends BaseApiController
{
    private $categoryService;

    /**
     * CategoryController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService,
                                CategoryResource $categoryResource
                                )
    {
        $this->categoryService = $categoryService;
        $this->categoryResource = $categoryResource;
    }

    /**
     * @param StoreCategoryRequest $request
     * @return bool
     */
    public function storeCategory(StoreCategoryRequest $request)
    {
        $attributes = $request->validated();

        return $this->categoryService->create($attributes);
    }

    /**
     * @param UpdateCategoryRequest $request
     * @param int $id
     * @return bool
     */
    public function updateCategory(UpdateCategoryRequest $request, int $id)
    {
        $attributes = $request->validated();

        return $this->categoryService->update($id, $attributes);
    }

    /**
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function showCategory(int $id)
    {
        $category = $this->categoryService->find($id);

        if (!$category){
            return response()->json(["error" => "Category not found."]);
        }
        $this->categoryResource->setData($category);
        return $this->categoryResource;

    }

    /**
     * @param int $id
     * @return string
     */
    public function deleteCategory(int $id)
    {
        if ($this->categoryService->delete($id)) {
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
        $category = $this->categoryService->getRootByCategory($categoryId);

        return $category;
    }

    /**
     * @param int $categoryId
     * @return mixed
     */
    public function getChildrenCategories(int $categoryId)
    {
        $categories = $this->categoryService->getChildrenByCategory($categoryId);

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
        $category = $this->categoryService->changePosition($categoryId, $position, $parentId);

        return $category;
    }

    /**
     * @param null|int $websiteId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function tree(TreeCategoryRequest $request, $websiteId = null)
    {
        return $this->categoryService->tree($websiteId, [
            'active' => (int)$request->get('active', 1)
        ]);
    }
}
