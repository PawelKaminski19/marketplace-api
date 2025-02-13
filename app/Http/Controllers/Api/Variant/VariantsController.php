<?php

namespace App\Http\Controllers\Api\Variant;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\VariantRequests\StoreVariantRequest;
use App\Http\Requests\VariantRequests\UpdateVariantRequest;
use App\Repositories\VariantRepository;
use Illuminate\Http\JsonResponse;

class VariantsController extends BaseApiController
{
    /**
     * @var VariantRepository
     */
    private $repository;

    /**
     * VariantsController constructor.
     * @param VariantRepository $repository
     */
    public function __construct(VariantRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * Return list of variants.
     * @return JsonResponse
     */
    public function index()
    {
        $variants = $this->repository->all();

        return response()->json([
            'variants' => $variants
        ]);
    }

    /**
     * Store the request data to database.
     * @param StoreVariantRequest $request
     * @return JsonResponse
     */
    public function store(StoreVariantRequest $request)
    {
        $data = $request->validated();

        $variant = $this->repository->create($data);

        return response()->json([
            'variant' => $variant
        ]);
    }

    /**
     * Update variant according to request data.
     * @param UpdateVariantRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateVariantRequest $request, int $id)
    {
        try {
            $data = $request->validated();
            $variant = $this->repository->update($id, $data);
            return response()->json([
                'variant' => $variant
            ]);
        } catch (\Exception $e) {
            $code = $e->getCode() === 0 ? 422 : $e->getCode();

            return response()->json([
                'errors' => true,
                'message' => $e->getMessage()
            ], $code);
        }
    }

    /**
     * Show specific variant base on id
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $variant = $this->repository->find($id);

        return response()->json([
            'variant' => $variant
        ]);
    }

    /**
     * Delete variant.
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id)
    {
        try {
            if ($this->repository->find($id)->delete()) {
                return response()->json([
                    'message' => 'Item deleted successfully'
                ]);
            }
        } catch (\Exception $e) {
            $code = $e->getCode() === 0 ? 422 : $e->getCode();

            return response()->json([
                'errors' => true,
                'message' => $e->getMessage()
            ], $code);
        }

        return response()->json([
            'message' => 'Item not deleted.'
        ]);
    }
}
