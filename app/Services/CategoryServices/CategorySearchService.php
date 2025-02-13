<?php

namespace App\Services\CategoryServices;

use App\Repositories\CategoryRepository;

class CategorySearchService
{
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
     * @param string $locale
     * @param string $url
     * @param int $websiteId
     * @param string $path
     * @return Category
     */
    public function findByPathAndWebsite(string $locale, string $path, int $websiteId)
    {
        return $this->categoryRepository->findByPathAndWebsite($locale, $path, $websiteId);
    }
}
