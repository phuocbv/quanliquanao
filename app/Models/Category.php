<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
//    protected $table = 'categories';
    protected $table = 'esp_categories';

    protected $fillable = [
        'name'
    ];

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, ProductCategory::class, 'category_id', 'product_id');
    }
}
