<?php
namespace App\Http\Controllers\Api\SellersAccount;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\SignupSellerAccountsRequests\CreateBusinessRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Services\ClientPaymentsServices\ClientPaymentsService;
use App\Services\ClientServices\ClientService;
use App\Services\SignupServices\GuestService;
use App\Models\ClientPayment;

use App\Http\Requests\SignupSellerAccountsRequests\CreatePaymentInfoRequest;

class CreatePaymentInfoController extends BaseApiController
{
    /**
     * CreatePaymentInfoController constructor.
     * @param ClientService $clientService
     * @param GuestService $guestService
     * @param ClientPaymentsService $countryService
     */
    public function __construct(
        ClientService $clientService,
        GuestService $guestService,
        ClientPaymentsService $clientPaymentsService
    ) {
        $this->clientPaymentsService = $clientPaymentsService;
        $this->guestService = $guestService;
        $this->clientService = $clientService;
    }

    /**
     * Create method
     *
     * @param CreatePaymentInfoRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function create(CreatePaymentInfoRequest $request)
    {
        $data = $request->all();
        $clientId = $data['client_id'] ?? null;
        $uuid = $data['uuid'] ?? null;

        if ($uuid && $clientId) {
            $guest = $this->guestService->findByUuid($uuid);
            $client = $this->clientService->find($clientId,false);
        }

        if ($client && $guest) {
            $clientPayment = $this->clientPaymentsService->create($data);

            $address = $clientPayment->address()->create(array_merge($data,$clientPayment->toArray(),["model" => ClientPayment::class,"model_id" => $clientPayment->id]));
            $clientPayment->address()->associate($address)->save();
            return response()->json(["data" => $clientPayment->load('client')->load('address')]);
        }
        return response()->json(["error" => "Wrong client or guest record not exist."]);
    }
}
