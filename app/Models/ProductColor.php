<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $table = 'esp_product_colors';

    protected $fillable = [
        'product_id',
        'color_id'
    ];

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
