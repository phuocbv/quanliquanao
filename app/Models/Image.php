<?php
namespace Laraspace\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'src',
        'type'
    ];
}
