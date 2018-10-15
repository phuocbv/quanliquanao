<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:25
 */

namespace Laraspace\Repositories;

use Laraspace\Models\Brand;
use Laraspace\Models\Product;
use Laraspace\Repositories\Contracts\ProductRepositoryInterface;

class ProductRepositoryEloquent extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        return $this->all()->sortByDesc('id');
    }

    public function searchProduct($condition = [])
    {
        $listProductIdCategory = $condition['listProductIdCategory'];
        $listProductIdColor = $condition['listProductIdColor'];
        $listProductIdSize = $condition['listProductIdSize'];

        $where = $condition['where'];
        $arrCondition = [];

        if (isset($where['gender']) && $where['gender'] != 0) {
            $arrCondition['gender'] = $where['gender'];
        }

        if (isset($where['brand'])) {
            $arrCondition['brand_id'] = $where['brand'];
        }

        $result = $this->findWhere($arrCondition);

        if (isset($where['category']) && $where['category'] != 0) {
            $result = $result->whereIn('id', $listProductIdCategory);
        }

        if (isset($where['color'])) {
            $result = $result->whereIn('id', $listProductIdColor);
        }

        if (isset($where['size'])) {
            $result = $result->whereIn('id', $listProductIdSize);
        }

        return $result;
    }
}
