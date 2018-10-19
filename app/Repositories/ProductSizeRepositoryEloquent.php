<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:25
 */

namespace Laraspace\Repositories;

use Laraspace\Models\ProductSize;
use Laraspace\Repositories\Contracts\ProductSizeRepositoryInterface;

class ProductSizeRepositoryEloquent extends BaseRepository implements ProductSizeRepositoryInterface
{
    public function __construct(ProductSize $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    /**
     * insert many product size
     *
     * @param array $data
     * @param $productId
     * @return null
     */
    public function insertMany($data = [], $productId)
    {
        $result = null;
        if (count($data) > 0) {
            $dataSize = [];

            foreach ($data as $value) {
                $dataSize[] = [
                    'product_id' => $productId,
                    'size_id' => $value
                ];
            }

            $result = ProductSize::insert($dataSize);
        }
        return $result;
    }
}
