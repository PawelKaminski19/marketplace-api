<?php

namespace App\Http\Controllers\Api\Tags;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\TagsServices\TagsService;
use Illuminate\Http\Request;

class TagsController extends BaseApiController
{
    /** @var $tagsService TagsService */
    protected $tagsService;

    public function __construct(TagsService $tagsService)
    {
        $this->tagsService = $tagsService;
    }

    public function index(Request $request, $websiteId)
    {
        return response()->json($this->tagsService->get($websiteId));
    }

    public function save(Request $request)
    {
        // TODO: check website_id field in request validation
        return response()->json($this->tagsService->save($request->all()));
    }
}
