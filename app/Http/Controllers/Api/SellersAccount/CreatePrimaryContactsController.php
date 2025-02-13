<?php
namespace App\Http\Controllers\Api\SellersAccount;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\SignupSellerAccountsRequests\CreateBusinessRequest;
use App\Http\Requests\SignupSellerAccountsRequests\CreatePrimaryContactRequest;
use App\Http\Resources\SignupResources\CreateCompanyResource;
use App\Services\AddressServices\AddressService;
use App\Services\ClientServices\ClientService;
use App\Services\CompanyServices\CompanyService;
use App\Services\CountryServices\CountryService;
use App\Services\SignupSellersAccountServices\CompanyPrimaryContactsService;
use App\Services\SignupServices\GuestService;
use Illuminate\Http\Request;

class CreatePrimaryContactsController extends BaseApiController
{
    /**
     * CreateShopController constructor.
     * @param CountryService $countryService
     * @param CompanyService $companyService
     * @param AddressService $addressService
     * @param GuestService $guestService
     * @param ClientService $clientService
     * @param CreateCompanyResource $createCompanyResource
     * @param CompanyPrimaryContactsService $companyPrimaryContactsService
     */
    public function __construct(
        CountryService $countryService,
        CompanyService $companyService,
        AddressService $addressService,
        GuestService $guestService,
        ClientService $clientService,
        CreateCompanyResource $createCompanyResource,
        CompanyPrimaryContactsService $companyPrimaryContactsService
    ) {
        $this->countryService = $countryService;
        $this->companyService = $companyService;
        $this->addressService = $addressService;
        $this->guestService = $guestService;
        $this->clientService = $clientService;
        $this->createCompanyResource = $createCompanyResource;
        $this->companyPrimaryContactsService = $companyPrimaryContactsService;
    }

    /**
     * Create method
     *
     * @param CreateBusinessRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function create(CreatePrimaryContactRequest $request)
    {
        $data = $request->all();

        $clientId = $data['client_id'] ?? null;

        if ($clientId) {
            $client = $this->clientService->find($clientId);
        }
        $uuid = $data['uuid'] ?? null;

        if ($uuid) {
            $guest = $this->guestService->findByUuid($uuid);
        }
        if ($guest && $client) {
            $country_id = $request->input('country_id', $guest->country_id);
            $country = $this->countryService->find($country_id, false);

            if ($country->contains_states == 1) {
                if (!isset($data["state"])) {
                    return response()->json(["error" => "For chosen country a state field is mandatory."]);
                }
            }
            if ($country->need_zip_code == 1) {
                if (!isset($data["zip"])) {
                    return response()->json(["error" => "For chosen country a zip field is mandatory."]);
                }
            }

            if ($client->company) {

                //let's create address entity
                $address = $this->addressService->create(array_merge(["country_id" => $country->id], $data));

                $cpc = $this->companyPrimaryContactsService->create(array_merge(["company_id" => $client->company->id, "address_id" => $address->id], $data));
                $result = [
                    "client" => $cpc->load('company')->load('address')->toArray(),
                ];
                return response()->json(["data" => $result]);
            }
        } else {
            return response()->json(["error" => "Wrong guest uuid."]);
        }
        return response()->json(["error" => "Wrong client or company not exist."]);
    }
}
