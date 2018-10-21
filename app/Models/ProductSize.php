<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
//    protected $table = 'product_sizes';
    protected $table = 'esp_product_sizes';

    protected $fillable = [
        'product_id',
        'size_id'
    ];

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
