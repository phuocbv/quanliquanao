<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:24
 */

namespace Laraspace\Repositories\Contracts;


interface SupplierRepositoryInterface
{
    public function getAll();

    //public function insertMany($input = [], $productId);
    public function createSupplier($data);

    public function updateSupplier($data, $supplierId);
}
