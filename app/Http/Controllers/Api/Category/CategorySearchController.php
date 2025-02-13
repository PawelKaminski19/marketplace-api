<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Requests\CategoriesRequests\CategorySearchRequest;
use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\CategoryRepository;
use App\Services\CategoryServices\CategoryService;
use App\Services\CategoryServices\CategorySearchService;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResources\CategorySearchCollectionResource;

class CategorySearchController extends BaseApiController
{
    private $categoryService;
    private $categorySearchService;

    /**
     * CategorySearchController constructor.
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService,
                                CategorySearchService $categorySearchService,
                                CategorySearchCollectionResource $categorySearchCollectionResource
                                )
    {
        $this->categoryService = $categoryService;
        $this->categorySearchService = $categorySearchService;
        $this->categorySearchCollectionResource = $categorySearchCollectionResource;
    }

    /**
     * findCategoryByUrlAndWebsite
     * @param CategorySearchRequest $request
     * @return bool
     */
    public function getByPathAndWebsite(CategorySearchRequest $request)
    {
        $data = $request->all();
        $locale = $data['locale'];
        $path = $data['path'];
        $websiteId = $data['website_id'];

        $categories = $this->categorySearchService->findByPathAndWebsite($locale, $path, $websiteId);
        if (!$categories){
            return response()->json(["error" => "Category not found."]);
        }
        $this->categorySearchCollectionResource->setData($categories);
        return $this->categorySearchCollectionResource;

    }

}
