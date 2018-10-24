<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class EspPricingDefault extends Model
{
    protected $table = 'esp_esp_pricing_default';

    protected $fillable = [
        'range',
        'percent',
        'freight'
    ];
}
