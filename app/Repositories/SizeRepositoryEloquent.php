<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:25
 */

namespace Laraspace\Repositories;

use Laraspace\Models\Size;
use Laraspace\Repositories\Contracts\SizeRepositoryInterface;

class SizeRepositoryEloquent extends BaseRepository implements SizeRepositoryInterface
{
    public function __construct(Size $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }
}
