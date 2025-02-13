<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\WebsitesProduct;
use App\Services\UploadServices\UploadByAWSService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

/**
 * Class TestController
 *
 * This is just a test controller - you can use it as you want to test various code.
 * @package App\Http\Controllers\Api
 */
class TestController extends BaseApiController
{
    public function __construct()
    {

    }

    public function index(Request $request)
    {
        //$uuid = 'eyJpdiI6IlhISFBuWEtybVpqb0RON1Q0RDBwSFE9PSIsInZhbHVlIjoiY2xUNHNCcFBKNXowRnBHTE81ZUNBcUJLZU9wYlwvVHFSWTFUcGdVRmFydjRKQWdpbVJsMFFMRmVsczdpOWJDcFciLCJtYWMiOiI5NzM2ZWU4NTczMGU2Y2Y1MDk1YWRiMDk0ZDA0ZmJhZTZlZmFiODcwNWEzYjQ2NGMwN2FhMmZiZWUxMWFkM2Y3In0=';
        //$file = Crypt::decryptString($uuid);

        //$file = "https://pbien-test.s3.eu-west-1.amazonaws.com/fa14b534e1e5c811083a5edd2b0056cb/2020/3/3186/5dd44dda-3140-4b28-ab43-71255d25abf0/5dd44dda-3140-4b28-ab43-71255d25abf0.jpg";

        /** @var UploadByAWSService $uploadService */
        //$uploadService = app()->make(UploadByAWSService::class);
        //$file = $uploadService->get($file);

        $product = \App\Models\Product::find(3186);
        $user = \App\Models\User::find(1);
        $images = ['sample1.jpg'];

        foreach($images as $imageName) {
            $file = new \Illuminate\Http\UploadedFile(database_path('seeds/devData/uploads/'.$imageName), $imageName);

            $data = [
                'data' => [
                    'filepond' => $file,
                    'model' => $product
                ],
                'clientId' => 2,
                'settingId' => 1,
                'customName' => null,
            ];

            $genericUpload = new \App\Services\UploadServices\GenericUpload($data, $user);
            $uuid = $genericUpload->process();
        }
    }
}
