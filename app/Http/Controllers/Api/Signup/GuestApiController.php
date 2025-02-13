<?php

namespace App\Http\Controllers\Api\Signup;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\SignupRequests\GuestSignupRequest;
use App\Http\Requests\SignupRequests\InitialVisitRequest;
use App\Http\Requests\SignupRequests\ResendEmailRequest;
use App\Http\Resources\GuestResources\GuestResource;
use App\Models\Guest;
use App\Notifications\GuestMailVerifyNotification;
use App\Repositories\TokenRepository;
use App\Services\CountryServices\CountryService;
use App\Services\DomainServices\DomainService;
use App\Services\SignupServices\GuestService;
use Illuminate\Http\Request;

class GuestApiController extends BaseApiController
{
    /**
     * GuestApiController constructor.
     * @param DomainService $domainService
     * @param GuestService $guestService
     * @param GuestResource $guestResource
     * @param TokenRepository $tokenRepository
     * @param CountryService $countryService
     */
    public function __construct(
        DomainService $domainService,
        GuestService $guestService,
        GuestResource $guestResource,
        TokenRepository $tokenRepository,
        CountryService $countryService
    ) {
        $this->domainService = $domainService;
        $this->guestService = $guestService;
        $this->guestResource = $guestResource;
        $this->tokenRepository = $tokenRepository;
        $this->countryService = $countryService;
    }

    /**
     * Initial visit on the signup site
     *
     * @param InitialVisitRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function initialVisit(InitialVisitRequest $request)
    {
        $data = $request->all();
        $uuid = $data['uuid'] ?? null;

        $checkIfExists = false;
        if ($uuid) {
            $checkIfExists = $this->guestService->findByUuid($uuid);
        }

        if (!$uuid || !$checkIfExists) {
            $created = $this->guestService->createInitialVisit($data);

            if ($created) {
                $this->guestResource->setData($created->toArray());
                return $this->guestResource;
            }
        }
        return response()->json(["message" => "Guest record already created."],400);
    }
    /**
     * Sign up a guest
     *
     * @param GuestSignupRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function signupCreateAccount(GuestSignupRequest $request)
    {
        $data = $request->all();
        $uuid = $data['uuid'] ?? null;
        $email = $data['email'] ?? null;

        $country = $this->countryService->find($data['phone_country_id']);
        $data['phone'] = str_replace("+" . $country->call_prefix, "", $data['phone']);

        $response = false;
        $checkIfExists = false;
        $checkIfEmailExists = false;

        if ($uuid) {
            $checkIfExists = $this->guestService->findByUuid($uuid);
        }
        if ($email) {
            $checkIfEmailExists = $this->guestService->findByEmail($email);
        }
        if ($checkIfEmailExists) {
            return response()->json(["error" => "Email already used. Aborting."],400);
        }
        $data['country_id'] = $data['phone_country_id'];

        if (!$uuid || !$checkIfExists) {

            $guest = $this->guestService->createInitialVisit($data);
            if (!$guest) {
                return response()->json(["error" => "Signup error."],400);
            }
        } else {
            $guest = $this->guestService->updateByUuid($uuid, $data);
        }

        if ($guest) {
            $token = $this->tokenRepository->generate('verify_email', 'App\Models\Guest', $guest->id);

            if ($token['token']) {
                try {
                    $guest->notify(new GuestMailVerifyNotification([
                        "fullUsername" => $guest->firstname . " " . $guest->lastname,
                        "token" => $token['token'],
                        "expiration_minutes" => $token['expiration_minutes'],
                    ]));
                } catch (Exception $e) {
                    \Log::debug("Email sending failure.");
                }
                $this->guestResource->setData(array_merge($guest->toArray(), ["emailVerifyingHash" => ["hash" => $token['hash']]]));
                return $this->guestResource;
            }
            return response()->json(["error" => "Guest Created. Email sending error."],400);
        }
        return response()->json(["error" => __('user.not_created')],400);
    }

    /**
     * Resend an email
     *
     * @param ResendEmailRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function resendEmail(ResendEmailRequest $request)
    {
        $data = $request->all();
        $uuid = $data['uuid'] ?? null;

        $response = false;
        $checkIfExists = false;
        if ($uuid) {
            $guest = $this->guestService->findByUuid($uuid);
            if ($guest) {
                $token = $this->tokenRepository->generate('verify_email', 'App\Models\Guest', $guest->id);

                if ($token['token']) {
                    $guest->notify(new GuestMailVerifyNotification([
                        "fullUsername" => $guest->firstname . " " . $guest->lastname,
                        "token" => $token['token'],
                        "expiration_minutes" => $token['expiration_minutes'],
                    ]));

                    $this->guestResource->setData(array_merge($guest->toArray(), ["emailVerifyingHash" => ["hash" => $token['hash']]]));
                    return $this->guestResource;
                }
                return response()->json(["error" => "Guest Created. Email sending error."],400);
            }
        }
        return response()->json(["error" => __('Resending email error')],400);
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
}
