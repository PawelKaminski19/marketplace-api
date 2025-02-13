<?php
namespace App\Http\Controllers\Api\SellersAccount;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\SignupSellerAccountsRequests\CreateBusinessRequest;
use App\Http\Resources\SignupResources\CreateCompanyResource;
use App\Services\AddressServices\AddressService;
use App\Services\ClientServices\ClientService;
use App\Services\CompanyServices\CompanyService;
use App\Services\CountryServices\CountryService;
use App\Services\LocationServices\LocationService;
use App\Services\SignupServices\GuestService;
use Illuminate\Http\Request;

class CreateBusinessController extends BaseApiController
{
    /**
     * CreateShopController constructor.
     * @param CountryService $countryService
     * @param LocationService $locationService
     * @param CompanyService $companyService
     * @param AddressService $addressService
     * @param GuestService $guestService
     * @param ClientService $clientService
     * @param CreateCompanyResource $createCompanyResource
     */
    public function __construct(
        CountryService $countryService,
        LocationService $locationService,
        CompanyService $companyService,
        AddressService $addressService,
        GuestService $guestService,
        ClientService $clientService,
        CreateCompanyResource $createCompanyResource
    ) {
        $this->countryService = $countryService;
        $this->locationService = $locationService;
        $this->companyService = $companyService;
        $this->addressService = $addressService;
        $this->guestService = $guestService;
        $this->clientService = $clientService;
        $this->createCompanyResource = $createCompanyResource;
    }

    /**
     * Create method
     *
     * @param CreateBusinessRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function create(CreateBusinessRequest $request)
    {
        $data = $request->all();

        $clientId = $data['client_id'] ?? null;

        if ($clientId) {
            $client = $this->clientService->find($clientId, false);
        }
        $uuid = $data['uuid'] ?? null;

        if ($uuid) {
            $guest = $this->guestService->findByUuid($uuid);
        }
        if ($guest && $client) {
            $phone_country_id = $request->input('phone_country_id', $guest->phone_country_id);
            $phone = $request->input('phone', $guest->phone);

            $country = $this->countryService->find($phone_country_id);
            $data["phone"] = str_replace("+" . $country->call_prefix, "", $phone);

            if ($guest->country->contains_states == 1) {
                if (!isset($data["state"])) {
                    return response()->json(["error" => "For chosen country a state field is mandatory."]);
                }
            }
            if ($guest->country->need_zip_code == 1) {
                if (!isset($data["zip"])) {
                    return response()->json(["error" => "For chosen country a zip field is mandatory."]);
                }
            }
            if ($guest->country->display_tax_label == 1) {
                if (!isset($data["tax_id_nr"])) {
                    return response()->json(["error" => "For chosen country a tax_id_nr field is mandatory."]);
                }
                if (!isset($data["vat_number"])) {
                    return response()->json(["error" => "For chosen country a vat_number field is mandatory."]);
                }
            }

            if ($guest && $client && $client->company) {

                $guestData = [
                    "firstname" => $guest->firstname,
                    "lastname" => $guest->lastname,
                    "email" => $guest->email,
                ];

                if ($client->company->location->address) {
                    $this->addressService->update($client->company->location->address->id, array_merge($data, $guestData));
                }
                $this->companyService->update($client->company->id, $data);

                $result = [
                    "client" => $client->toArray(),
                    "company" => $client->company->load('location')->toArray(),
                    "location" => $client->company->location->toArray(),
                    "address" => $client->company->location->address->load('gender', 'country')->toArray(),
                ];
                $this->createCompanyResource->setData($result);
                return $this->createCompanyResource;
            }
        } else {
            return response()->json(["error" => "Wrong guest uuid."]);
        }

        return response()->json(["error" => "Wrong client or company not exist."]);

    }
}
