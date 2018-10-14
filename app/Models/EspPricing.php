<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class EspPricing extends Model
{
    protected $table = 'esp_pricings';

    protected $fillable = [
        'range',
        'percent',
        'freight'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
