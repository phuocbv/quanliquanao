<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:25
 */

namespace Laraspace\Repositories;

use Laraspace\Models\Color;
use Laraspace\Models\ProductColor;
use Laraspace\Repositories\Contracts\ProductColorRepositoryInterface;

class ProductColorRepositoryEloquent extends BaseRepository implements ProductColorRepositoryInterface
{
    public function __construct(ProductColor $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function insertMany($data = [], $productId)
    {
        $result = true;

        if (count($data) > 0) {
            $dataColor = [];

            foreach ($data as $value) {
                $dataColor[] = [
                    'product_id' => $productId,
                    'color_id' => $value
                ];
            }

            $result = ProductColor::insert($dataColor);
        }

        return $result;
    }

    public function findOrInsertMany($data = [], $productId)
    {
        $result = true;

        if (count($data) > 0) {
            $dataColor = [];

            foreach ($data as $value) {
                $color = Color::where([
                    'name' => $value
                ])->first();

                if ($color) {
                    $dataColor[] = [
                        'product_id' => $productId,
                        'color_id' => $color->id
                    ];
                }
            }

            $result = ProductColor::insert($dataColor);
        }

        return $result;
    }
}
