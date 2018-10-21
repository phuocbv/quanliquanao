<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:25
 */

namespace Laraspace\Repositories;

use Laraspace\Models\ProductCategory;
use Laraspace\Models\ProductSize;
use Laraspace\Repositories\Contracts\ProductCategoryRepositoryInterface;

class ProductCategoryRepositoryEloquent extends BaseRepository implements ProductCategoryRepositoryInterface
{
    public function __construct(ProductCategory $model)
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
        $result = true;

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

    public function findOrCreate($data = [])
    {
//        $category = $this->findWhere([
//            'name' => $data['name']
//        ])->first();
//
//        if (!$category) {
//            $category = $this->create([
//                'name' => $data['name']
//            ]);
//        }
//
//        return $category;
    }
}
