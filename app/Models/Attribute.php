<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'esp_attributes';

    protected $fillable = [
        'name'
    ];
}
