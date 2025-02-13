<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantCombination extends Model
{
    protected $table = 'product_variants_combinations';

    protected $fillable = [
        'client_id', 'product_id', 'reference', 'reference_brand', 'ean13', 'price', 'weight', 'quantity',
        'standard', 'available_text', 'available_days', 'available_date', 'created_at', 'updated_at'
    ];

    protected $dates = ['available_date', 'created_at', 'updated_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variants()
    {
        return $this->belongsToMany(Variant::class, 'product_variants');
    }
}
