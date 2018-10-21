<?php

namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierPricing extends Model
{
    protected $table = 'esp_supplier_pricings';

    protected $fillable = [
        'min',
        'max',
        'unit_price',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
