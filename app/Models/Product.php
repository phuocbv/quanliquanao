<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, ProductCategory::class, 'product_id', 'category_id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, ProductColor::class, 'product_id', 'color_id');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, ProductSize::class, 'product_id', 'size_id');
    }

    public function images()
    {

    }

    public function espPricing()
    {
        return $this->hasMany(EspPricing::class, 'product_id');
    }

   // public function
}
