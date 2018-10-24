<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table = 'esp_sizes';

    protected $fillable = [
        'size'
    ];

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class, 'size_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sizes', 'size_id', 'product_id');
    }
}
