<?php


namespace App\Repositories;

use App\Models\Guest;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Uuid;

class GuestRepository extends BaseRepository
{
    /**
     * Initialize guest repository instance.
     *
     * @param Guest $model
     */
    public function __construct(Guest $model)
    {
        $this->model = $model;
    }

    /**
     * find by Uuid
     *
     * @param string $uuid
     * @return array
     */
    public function findByUuid(string $uuid)
    {
        return $this->model->where('uuid', $uuid)->first();
    }

    /**
     * find by email
     *
     * @param string $email
     * @return array
     */
    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Update by Uuid
     *
     * @param string $uuid
     * @return array
     */
    public function updateByUuid(string $uuid, array $data)
    {
        /** @var Model $object */
        $object = $this->model->where('uuid', $uuid)->first();

        if (!is_null($object)) {
            $object->update($data);
            return $object;
        }
        return false;
    }

    /**
     * find by Uuid
     *
     * @param string $uuid
     * @return array
     */
    public function findBySessionId(string $session)
    {
        return $this->model->where('session', $session)->first();
    }

    /**
     * Move Guest to Users table
     * And delete Token
     *
     * @param $guest
     * @return User|bool
     */
    public function upgradeGuestToUser($guest)
    {
        $token = Token::where('model', '=', \App\Models\Guest::class)
            ->where('model_id', '=', $guest->id)
            ->where('method', '=', 'verify_email')
            ->where('used', '=', 1)
            ->orderBy('used_date')
            ->first();

        if ($token && $guest) {
            $checkIfExists = User::where('email', $guest->email)->first();

            if ($checkIfExists) {
                return null;
            }
            $user = new User();

            $user->name = Str::ucfirst($guest->firstname) . " " . Str::ucfirst($guest->lastname);
            $user->email = $guest->email;
            $user->name = $guest->email;
            $user->email_verified_at = Carbon::now();
            $user->password = bcrypt(Uuid::generate(4));

            if ($user->save()) {
                $token->delete();
                return $user;
            }
        }
        return false;
    }
}
