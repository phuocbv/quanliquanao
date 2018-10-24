<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:24
 */

namespace Laraspace\Repositories\Contracts;


interface AttributeValueRepositoryInterface
{
    public function getAll();

    public function insertListAttribute($dataImport, $fields, $productId);
}
