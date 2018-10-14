<?php

namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierPricing extends Model
{
    protected $table = 'supplier_pricings';

    protected $fillable = [
        'min',
        'max',
        'unit_price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
