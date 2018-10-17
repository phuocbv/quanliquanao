<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colors';

    protected $fillable = [
        'name',
        'code'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, ProductColor::class, 'color_id', 'product_id');
    }

    public function productColors()
    {
        return $this->hasMany(ProductColor::class, 'color_id');
    }
}
