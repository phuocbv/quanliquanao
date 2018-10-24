<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierField extends Model
{
    protected $table = 'esp_supplier_fields';

    protected $fillable = [
        'supplier_id',
        'field_id'
    ];
}
