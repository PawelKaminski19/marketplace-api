<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseApiController;
use Illuminate\Http\Request;

class BaseAdminController extends BaseApiController
{
    /**
     * Create a new BaseAdminApiController instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
}
