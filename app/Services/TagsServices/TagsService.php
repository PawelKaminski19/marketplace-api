<?php

namespace App\Services\TagsServices;

use App\Models\Tag;
use App\Repositories\TagsRepository;
use Session;
use Uuid;

class TagsService
{
    /** @var TagsRepository */
    protected $tagsRepository;

    public function __construct()
    {
        $this->tagsRepository = app()->make(TagsRepository::class);
    }

    public function get($websiteId)
    {
        return $this->tagsRepository->query()->where('website_id', $websiteId)->orderBy('name')->get();
    }

    public function save($data)
    {
        if (!empty($data['id'])) {
            $model = $this->tagsRepository->find($data['id']);
        }
        else {
            // check if tag already exists
            $model = $this->tagsRepository->query()->where('name', $data['name'])->where('website_id', $data['website_id'])->first();
            if (!$model) {
                $model = new Tag($data);
            }
        }
        $model->fill($data);
        return $model->save();
    }
}
