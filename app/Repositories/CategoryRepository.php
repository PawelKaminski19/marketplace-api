<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryRepository extends BaseRepository
{
    /**
     * Initialize repository instance.
     *
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
        // $this->model->scopeWhereTranslation()
    }

    /**
     * Get category by url and website
     *
     * @param string $locale
     * @param string $path
     * @param int $websiteId
     * @return Model
     */
    public function findByPathAndWebsite(string $locale, string $path, int $websiteId = null)
    {
        $category = $this->model->whereTranslation('path', $path, $locale);

        if ($websiteId) {
            $category = $category->where('website_id', '=', $websiteId);
        }

        return $category->first();
    }

    /**
     * Get Top Level Category - Root
     * E.g: CatRoot > CatNavi > CatSubNavi
     * >> getRootByCategory(CatSubNavi)
     * >> outputs CatRoot
     *
     * @param int $categoryId
     * @return mixed
     */
    public function getRootByCategory(int $categoryId)
    {
        $category = $this->model->find($categoryId);

        while ($category->parent !== null) {
            $category = $category->parent;
        }

        return $category;
    }

    /**
     * Get all 1-level down children of given Category
     *
     * @param Category $category
     * @return bool
     */
    public function getChildrenByCategory(int $categoryId)
    {
        $category = $this->model->find($categoryId);

        if ($category) {
            $categories = $this->model->where('website_id', '=', $category->website_id)
                ->where('parent_id', '=', $category->id)
                ->get();
        } else {
            return false;
        }
    }

    /**
     * Change position of an item
     *
     * @param Category $category
     * @param int $position
     * @param int|null $parentId
     * @return bool
     */
    public function changePosition(Category $category, int $position, int $parentId = null)
    {
        // Check if position is valid
        // Position can't be below 0
        // If no new parent and position is equal to actual, do nothing
        if ($position < 0 || ($parentId === null && $category->position === $position)) {
            return false;
        }

        // Decide who's the parent
        if ($parentId !== null) {
            $parent = $this->model->find($parentId);

            if ($parent) {
                $oldParentId = $category->parent_id;
            } else {
                $parent = $category->parent;
            }
        } else {
            $oldParentId = null;
            $parent = $category->parent;
        }

        // Move
        if ($position < $category->position && $parent->id === $category->parent_id) {
            $categoriesToMove = $this->model->where('website_id', '=', $category->website_id)
                ->where('parent_id', '=', $parent->id)
                ->where('position', '>=', $position)
                ->where('position', '<', $category->position)
                ->where('id', '!=', $category->id)
                ->get();

            foreach ($categoriesToMove as $cat) {
                $cat->position++;
                $cat->save();
            }
        } elseif ($position > $category->position && $parent->id === $category->parent_id) {
            $categoriesToMove = $this->model->where('website_id', '=', $category->website_id)
                ->where('parent_id', '=', $parent->id)
                ->where('position', '<=', $position)
                ->where('position', '>', $category->position)
                ->where('id', '!=', $category->id);

            $categoriesToMove = $categoriesToMove->get();

            foreach ($categoriesToMove as $cat) {
                $cat->position--;
                $cat->save();
            }
        } elseif ($parent->id !== $category->parent_id) {
            $categoriesToMove = $this->model->where('website_id', '=', $category->website_id)
                ->where('parent_id', '=', $parent->id)
                ->where('position', '>=', $position)
                ->where('id', '!=', $category->id)
                ->get();

            foreach ($categoriesToMove as $cat) {
                $cat->position++;
                $cat->save();
            }
        }

        // If we're moving a Category to different parent
        // Clean up order in the old parent
        if (isset($oldParentId) && !empty($oldParentId) && $oldParentId !== $category->parent_id) {
            $categoriesToMoveOldParent = $this->model->where('website_id', '=', $category->website_id)
                ->where('parent_id', '=', $oldParentId)
                ->where('position', '>', $category->position)
                ->get();

            foreach ($categoriesToMoveOldParent as $cat) {
                $cat->position--;
                $cat->save();
            }
        }

        // Finalize our model
        $category->position = $position;
        $category->parent_id = $parent->id;

        return $category->save();
    }

    /**
     * Get categories tree.
     *
     * @param int $websiteId
     * @param array $filters
     * @return Collection
     */
    public function tree($websiteId, $filters)
    {
        return $this->model->tree($websiteId, $filters);
    }

}
