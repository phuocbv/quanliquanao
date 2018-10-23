<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $table = 'esp_attribute_values';

    protected $fillable = [
        'value',
        'attribute_id'
    ];
}
