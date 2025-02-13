<?php

namespace App\Http\Controllers\Api\VariantGroup;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\VariantGroupRequests\StoreVariantGroupRequest;
use App\Http\Requests\VariantGroupRequests\UpdateVariantGroupRequests;
use App\Repositories\VariantGroupRepository;
use Exception;
use Illuminate\Http\JsonResponse;

class VariantGroupsController extends BaseApiController
{

    /**
     * Repository for variant groups
     * @var VariantGroupRepository
     */
    private $repository;

    /**
     * VariantGroupsController constructor.
     * @param VariantGroupRepository $repository
     */
    public function __construct(VariantGroupRepository $repository)
    {
        parent::__construct();

        $this->repository = $repository;
    }

    /**
     * List all the variant groups.
     * @return JsonResponse
     */
    public function index()
    {
        $variantGroups = $this->repository->all();

        return response()->json([
            'variantGroups' => $variantGroups
        ]);
    }

    /**
     * Returns specific variant group.
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        $variantGroup = $this->repository->find($id, true);

        return response()->json([
            'variantGroup' => $variantGroup
        ]);
    }

    /**
     * Stores the request data to database.
     * @param StoreVariantGroupRequest $request
     * @return JsonResponse
     */
    public function store(StoreVariantGroupRequest $request)
    {
        $data = $request->validated();

        $variantGroup = $this->repository->create($data);

        return response()->json([
            'variantGroup' => $variantGroup
        ]);
    }

    /**
     * Update variant group according to request data.
     * @param UpdateVariantGroupRequests $requests
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateVariantGroupRequests $requests, int $id)
    {
        try {
            $data = $requests->validated();
            $variantGroup = $this->repository->update($id, $data);
            return response()->json([
                'variantGroup' => $variantGroup
            ]);
        } catch (Exception $e) {
            $code = $e->getCode() === 0 ? 422 : $e->getCode();

            return response()->json([
                'errors' => true,
                'message' => $e->getMessage()
            ], $code);
        }
    }

    /**
     * Delete variant group.
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
        } catch (Exception $e) {
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
