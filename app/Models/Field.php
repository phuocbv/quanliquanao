<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = 'esp_fields';

    protected $fillable = [
        'name'
    ];
}
