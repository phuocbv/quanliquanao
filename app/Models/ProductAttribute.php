<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $table = 'esp_product_attributes';

    protected $fillable = [
        'product_id',
        'attribute_value_id'
    ];
}
