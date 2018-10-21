<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:25
 */

namespace Laraspace\Repositories;

use Laraspace\Models\SupplierPricing;
use Laraspace\Repositories\Contracts\SupplierPricingRepositoryInterface;

class SupplierPricingRepositoryEloquent extends BaseRepository implements SupplierPricingRepositoryInterface
{
    public function __construct(SupplierPricing $model)
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
            $dataSupplierPricing = [];

            foreach ($data as $value) {
                $dataSupplierPricing[] = [
                    'min' => $value->min,
                    'max' => $value->max,
                    'unit_price' => $value->unit_price,
                    'product_id' => $productId
                ];
            }

            $result = SupplierPricing::insert($dataSupplierPricing);
        }

        return $result;
    }

    public function insertManyNotMax($data = [], $productId)
    {
        $result = true;

        if (count($data) > 0) {
            $dataSupplierPricing = [];

            foreach ($data as $value) {
                $dataSupplierPricing[] = [
                    'min' => $value['min'],
                    'unit_price' => $value['unit_price'],
                    'product_id' => $productId
                ];
            }

            $result = SupplierPricing::insert($dataSupplierPricing);
        }

        return $result;
    }
}
