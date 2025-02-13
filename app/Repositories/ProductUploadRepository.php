<?php
namespace App\Repositories;

use App\Models\ProductUpload;

class ProductUploadRepository
{
    protected $model;

    public function __construct(ProductUpload $model)
    {
        $this->model = $model;
    }
}
