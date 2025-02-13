<?php
namespace App\Repositories;

use App\Models\ClientPayment;

/**
 * Class ClientPaymentsRepository.
 *
 * @package App\Repository
 */
class ClientPaymentsRepository extends BaseRepository
{

    /**
     * Initialize ClientPaymentRepository instance.
     *
     * @param ClientPayment $model
     */
    public function __construct(ClientPayment $model)
    {
        $this->model = $model;
    }
}
