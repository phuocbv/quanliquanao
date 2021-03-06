<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:24
 */

namespace Laraspace\Repositories\Contracts;


interface ProductRepositoryInterface
{
    public function getAll();

    public function searchProduct($condition = []);

    public function saveProduct($input = []);

    public function updateProduct($input = [], $id);

    public function importProduct($dataImports, $supplier);
}
