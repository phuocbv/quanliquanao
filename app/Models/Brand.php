<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
//    protected $table = 'brands';
    protected $table = 'esp_brands';

    protected $fillable = [
        'name'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }
}
