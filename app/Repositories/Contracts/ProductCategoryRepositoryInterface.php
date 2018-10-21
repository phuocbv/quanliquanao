<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:24
 */

namespace Laraspace\Repositories\Contracts;


interface ProductCategoryRepositoryInterface
{
    public function getAll();

    public function insertMany($data = [], $productId);

    public function findOrCreate($data = []);
}
