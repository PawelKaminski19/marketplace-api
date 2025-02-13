<?php

namespace App\Services\TokenServices;

use App\Repositories\TokenRepository;

/**
 * Class GenerateTokenService.
 *
 * @package App\Services\TokenServices
 */
class GenerateTokenService
{
    /** @var TokenRepository */
    protected $tokenRepository;

    /**
     * Create a new GenerateTokenService instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->tokenRepository = app()->make(TokenRepository::class);
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
        return $this->tokenRepository->generate($method, $model, $model_id, $length, $expiration, $type);
    }

}
