<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class EspPricing extends Model
{
    protected $table = 'esp_esp_pricings';

    protected $fillable = [
        'range',
        'percent',
        'freight',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
