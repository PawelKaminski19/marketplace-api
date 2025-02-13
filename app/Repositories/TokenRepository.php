<?php
namespace App\Repositories;

use App\Models\Token;
use App\Packages\TokenStatuses;
use Carbon\Carbon;

class TokenRepository extends BaseRepository
{

    protected $model;

    public function __construct(Token $model)
    {
        $this->model = $model;
    }
    /**
     * Generate a Token
     *
     * @param $method
     * @param $model
     * @param $model_id
     * @param int $length
     * @param int $expiration
     * @param string $type
     * @return array
     */
    public function generate($method, $model, $model_id, $length = 6, $expiration = 30, $type = 'verify')
    {
        $token = new Token();
        $token->type = $type;
        $token->method = $method;
        $token->model = $model;
        $token->model_id = $model_id;
        $token->hash = $this->generateHash();
        $token->token = $this->generateToken($length);
        $token->expiration_minutes = $expiration;
        $token->expiration_date = Carbon::now()->addMinutes($expiration);
        $token->active = 1;

        $token->save();

        return $token->toArray();
    }

    /**
     * Check if given Token is valid
     *
     * @param $method
     * @param $model
     * @param $hash
     * @return mixed
     */
    public function check($method, $model, $hash)
    {
        $token = Token::where('hash', '=', $hash)
            ->where('model', '=', $model)
            ->where('method', '=', $method)
            ->where('active', '=', 1)
            ->get()
            ->first();

        if (!$token) {
            return TokenStatuses::notFound();
        } else if ($token->used) {
            return TokenStatuses::used();

        } else if ($token->expiration_date < Carbon::now()) {
            return TokenStatuses::expired();
        }

        return $token;

    }

    /**
     * Find by Token
     *
     * @param $token
     * @return bool
     */
    public function findByToken($token)
    {
        $token = Token::where('token', '=', $token)->first();

        return $token ? $token->toArray() : false;
    }

    /**
     * Count models with given conditions
     *
     * @param $method
     * @param $model
     * @param $model_id
     * @return mixed
     */
    public function countModels($method, $model, $model_id) {
        return Token::where('method', '=', $method)
            ->where('model', '=', $model)
            ->where('model_id', '=', $model_id)
            ->where('created_at', '>=', Carbon::now()->subMinutes(10))
            ->get()
            ->count();
    }

    /**
     * Cronjob: clean outdated (>24hrs) Tokens
     *
     * @return bool
     */
    public function cleanOutdatedTokens()
    {
        $tokens = Token::where('created_at', '<', Carbon::now()->subDay())->get();

        foreach ($tokens as $token) {
            $token->delete();
        }

        $tokens = Token::where('created_at', '<', Carbon::now()->subDay())->get();

        if ($tokens->count() == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Generate a hash
     *
     * @param $length
     * @return string
     */
    private function generateHash()
    {
        $hash = sha1(time());

        return $hash;
    }

    /**
     * Generate a token
     *
     * @param $length
     * @return int
     */
    private function generateToken($length)
    {
        $start = str_pad(1,  $length, "0");
        $end = str_pad(9,  $length, "9");
        $token = mt_rand($start, $end);

        return $token;
    }

    /**
     * Generate a token
     *
     * @param string $hash
     * @return int
     */
    public function updateTokenUsage(string $hash)
    {
        $token = Token::where('hash', '=', $hash)
            ->where('active', '=', 1)
            ->get()
            ->first();

        $data = ["used" => "1",
                 "active" => "0",
                 "used_date" => Carbon::now()];

        if (!is_null($token)) {
            return $token->update($data);
        }

        return false;
    }
}
