<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'esp_suppliers';

    protected $fillable = [
        'name'
    ];

    public function fields()
    {
        return $this->belongsToMany(Field::class, 'esp_supplier_fields', 'supplier_id', 'field_id');
    }
}
