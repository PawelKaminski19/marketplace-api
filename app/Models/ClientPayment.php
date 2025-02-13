<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientPayment extends Model
{
    protected $table = 'client_payments';

    /**
     * @var array
     */
    protected $fillable = [
        'client_id', 'address_id', 'owner', 'iban', 'bic', 'default', 'invoice'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo('model', 'model', 'model_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Client
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo|Address
     */
    public function address()
    {
        return $this->belongsTo(Address::class, "address_id");
    }

}
