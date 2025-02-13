<?php
namespace App\Repositories;

use App\Models\Address;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

/**
 * Class TagsRepository.
 *
 * @package App\Repository
 */
class TagsRepository extends BaseRepository
{
    /**
     * @param Tag $model
     */
    public function __construct(Tag $model)
    {
        $this->model = $model;
    }
}
