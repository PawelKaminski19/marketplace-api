<?php
namespace App\Repositories;

use App\Models\Address;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

/**
 * Class AddressRepository.
 *
 * @package App\Repository
 */
class AddressRepository extends BaseRepository
{

    /**
     * Initialize Address repository instance.
     *
     * @param Address $model
     */
    public function __construct(Address $model)
    {
        $this->model = $model;
    }
}
