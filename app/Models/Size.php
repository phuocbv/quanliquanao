<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table = 'sizes';

    protected $fillable = [
        'size'
    ];

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sizes', 'size_id', 'product_id');
    }
}
