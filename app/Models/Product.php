<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
//    protected $table = 'products';
    protected $table = 'esp_products';

    protected $fillable = [
        'code',
        'name',
        'weight',
        'gender',
        'description',
        'thumbnail',
        'supplier_id',
        'brand_id'
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
        return $this->belongsToMany(Category::class, 'esp_product_categories', 'product_id', 'category_id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'esp_product_colors', 'product_id', 'color_id');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'esp_product_sizes', 'product_id', 'size_id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'esp_product_images', 'product_id', 'image_id');
    }

    public function espPricings()
    {
        return $this->hasMany(EspPricing::class, 'product_id');
    }

    public function supplierPricings()
    {
        return $this->hasMany(SupplierPricing::class, 'product_id');
    }

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class, 'product_id');
    }

    public function productColors()
    {
        return $this->hasMany(ProductColor::class, 'product_id');
    }

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class, 'product_id');
    }
}
