<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'esp_suppliers';

    protected $fillable = [
        'name'
    ];
}
