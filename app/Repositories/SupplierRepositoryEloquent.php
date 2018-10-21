<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:25
 */

namespace Laraspace\Repositories;

use Laraspace\Models\Supplier;
use Laraspace\Repositories\Contracts\SupplierRepositoryInterface;

class SupplierRepositoryEloquent extends BaseRepository implements SupplierRepositoryInterface
{
    public function __construct(Supplier $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }
}
