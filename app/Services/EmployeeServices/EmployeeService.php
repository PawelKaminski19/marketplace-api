<?php
namespace App\Services\EmployeeServices;

use App\Models\Employee;
use App\Models\Guest;
use App\Repositories\EmployeeRepository;
use App\Repositories\GuestRepository;

/**
 * Class EmployeeService.
 *
 * @package App\Services\GuestServices
 */
class EmployeeService
{
    /**
     * Create a new GuestService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->employeeRepository = app()->make(EmployeeRepository::class);
        $this->guestRepository = app()->make(GuestRepository::class);
    }

    /**
     * Create a Employee using Guest instance.
     *
     * @return void
     */
    public function createFromGuest($gs, $client)
    {
        $employee = $this->employeeRepository->create([
            "client_id" => $client->id,
            "lang_id" => $gs->lang_id ?? 1,
            "gender_id" => $gs->gender_id ?? 1,
            "lastname" => $gs->lastname,
            "firstname" => $gs->firstname,
            "active" => "1",
            "terms_accepted" => "1",
            "terms_accepted_time" => $gs->created_at,
        ]);
        $guest = $this->guestRepository->update($gs->id, ["employee_id" => $employee->id]);

        return $employee;
    }
}
