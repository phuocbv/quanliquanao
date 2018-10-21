<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'esp_product_images';

    protected $fillable = [
        'product_id',
        'image_id'
    ];

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
