<?php
namespace App\Http\Controllers\Api\Signup;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\SignupRequests\CreateCompanyRequest;
use App\Http\Resources\SignupResources\CreateCompanyResource;
use App\Services\AddressServices\AddressService;
use App\Services\ClientServices\ClientService;
use App\Services\CompanyServices\CompanyService;
use App\Services\CountryServices\CountryService;
use App\Services\LocationServices\LocationService;
use App\Services\SignupServices\GuestService;
use Illuminate\Http\Request;

class CreateShopController extends BaseApiController
{
    /**
     * CreateShopController constructor.
     * @param CountryRepository $countryRepository
     * @param DomainService $domainService
     * @param guestService $guestService
     * @param AddressService $addressService
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
     * During this process system should create entities: website, company, location, companies_websites
     * @param CreateShopRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function create(CreateCompanyRequest $request)
    {
        $data = $request->all();

        $uuid = $data['uuid'] ?? null;

        if ($uuid) {
            $guest = $this->guestService->findByUuid($uuid);
        }

        if ($guest) {

            //lets find country by iso
            $country = $this->countryService->findByIso($data['country_iso']);

            //let's update guest
            $this->guestService->update(
                $guest->id,
                [
                    "gender_id" => $guest->gender_id,
                    "country_id" => $country->id,
                ]
            );

            //let's create address entity
            $address = $this->addressService->create(["gender_id" => $guest->gender_id,
                "country_id" => $country->id,
            ]);
            //let's create location entity
            $location = $this->locationService->create(["address_id" => $address->id,
                "active" => "1"]);
            //lets create company by title
            $company = $this->companyService->create(["title" => $data['title'],
                "business_type" => $data['business_type'],
                "location_id" => $location->id,
            ]);
            //lets create company by title
            $client = $this->clientService->update(
                $data['client_id'],
                [
                    "company_id" => $company->id,
                ]
            );
            $result = [
                "client" => $client->toArray(),
                "company" => $company->load('location')->toArray(),
                "location" => $location->toArray(),
                "address" => $address->load('gender', 'country')->toArray(),
            ];

            $this->createCompanyResource->setData($result);
            return $this->createCompanyResource;
        }

        return response()->json(["error" => "Wrong uuid."],400);
    }
}
