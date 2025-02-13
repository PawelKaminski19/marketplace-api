<?php
namespace App\Http\Controllers\Api\Signup;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\SignupRequests\SendSMSRequest;
use App\Http\Requests\SignupRequests\VerifyPhoneRequest;
use App\Http\Resources\GuestResources\GuestResource;
use App\Models\Guest;
use App\Repositories\ClientRepository;
use App\Repositories\GuestRepository;
use App\Services\ClientServices\ClientService;
use App\Services\CountryServices\CountryService;
use App\Services\DomainServices\DomainService;
use App\Services\EmployeeServices\EmployeeService;
use App\Services\SignupServices\GuestService;
use App\Services\SoftwareOwnerServices\SoftwareOwnerService;
use App\Services\Twilio\Verification;
use Illuminate\Http\Request;

class VerifyPhoneController extends BaseApiController
{
    /**
     * VerifyPhoneController constructor.
     * @param DomainService $domainService
     * @param GuestService $guestService
     * @param ClientService $clientService
     * @param GuestResource $guestResource
     * @param Verification $twilioService
     * @param ClientRepository $clientRepository
     * @param GuestRepository $guestRepository
     * @param EmployeeService $employeeService
     * @param CountryService $countryService
     * @param SoftwareOwnerService $softwareOwnerService
     */
    public function __construct(
        DomainService $domainService,
        GuestService $guestService,
        ClientService $clientService,
        GuestResource $guestResource,
        Verification $twilioService,
        ClientRepository $clientRepository,
        GuestRepository $guestRepository,
        EmployeeService $employeeService,
        CountryService $countryService,
        SoftwareOwnerService $softwareOwnerService
    ) {
        $this->domainService = $domainService;
        $this->guestService = $guestService;
        $this->clientService = $clientService;
        $this->employeeService = $employeeService;
        $this->twilio = $twilioService;
        $this->guestResource = $guestResource;
        $this->clientRepository = $clientRepository;
        $this->guestRepository = $guestRepository;
        $this->countryService = $countryService;
        $this->softwareOwnerService = $softwareOwnerService;
    }

    /**
     * Send SMS
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function sendSMS(SendSMSRequest $request)
    {
        $channel = $request->input('channel', 'sms');

        if (!in_array($channel, ["sms", "call"])) {
            $channel = "sms";
        }
        $uuid = $request->input('uuid', null);
        if ($uuid) {
            $guest = $this->guestService->findByUuid($uuid);
        }

        if ($guest) {
            $phone_country_id = $request->input('phone_country_id', $guest->phone_country_id);
            $phone = $request->input('phone', $guest->phone);
            $country = $this->countryService->find($phone_country_id);

            $trimPhone = str_replace("+" . $country->call_prefix, "", $phone);

            //let's update guest
            $this->guestService->update(
                $guest->id,
                [
                    "phone" => $trimPhone,
                ]
            );

            $verify = $this->twilio->startVerification("+" . $country->call_prefix . $phone, $channel);

            if ($verify->isValid()) {
                $message = __('token.verified_and_sent');
                $status = 200;
            } else {
                $message = "Token not verified. Access Denied.";
                $status = 400;
            }
            return response()->json(["message" => $message], $status);
        }
        return response()->json(["message" => "Wrong uuid."],400);
    }
    /**
     * Verify guests phone and upgrate guest to user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function verify(VerifyPhoneRequest $request)
    {
        $token = $request->input('token');
        $uuid = $request->input('uuid');
        $message = null;

        $gs = $this->guestService->findByUuid($uuid);
        if ($gs) {

            $country = $this->countryService->find($gs->phone_country_id);

            $verification = $this->twilio->checkVerification("+" . $country->call_prefix . $gs->phone, $token);

            if ($verification->isValid()) {
                // collecting guest object by id

                //create user from guest
                $user = $this->guestRepository->upgradeGuestToUser($gs);
                //create client from guest
                $client = $this->clientService->createFromGuest($gs)->fresh();
                //create softwareOwner
                $softwareOwner = $this->softwareOwnerService->create(["client_id" => $client->id, "lang_id" => $country->id]);

                if (empty($user)) {
                    return response()->json(["message" => __('Email already taken or token already used.')],400); 
                }
                if (empty($client)) {
                    return response()->json(["message" => __('Wrong client.')],400);
                }
                if ($user && $client) {
                    //creating employee
                    $employee = $this->employeeService->createFromGuest($gs, $client);
                    //attaching employee to user
                    $user->fresh()->employees()->syncWithoutDetaching([$employee->id]);

                    //let's update guest
                    $this->guestService->update(
                        $gs->id,
                        [
                            "employee_id" => $employee->id,
                            "user_id" => $user->id,
                        ]
                    );

                    return response()->json(array_merge(["message" => __('Token verification successful.')], ["client" => $client->id]));
                }

            } else {
                return response()->json(["message" => __('Token invalid')],400);
            }
        } else {
            return response()->json(["message" => __('User not found')],400);
        }
        return response()->json(["message" => $message]);
    }
}
