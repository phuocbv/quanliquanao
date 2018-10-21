<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:25
 */

namespace Laraspace\Repositories;

use Laraspace\Models\Color;
use Laraspace\Models\EspPricing;
use Laraspace\Repositories\Contracts\EspPricingRepositoryInterface;

class EspPricingRepositoryEloquent extends BaseRepository implements EspPricingRepositoryInterface
{
    public function __construct(EspPricing $model)
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
            $dataEspPricing = [];

            foreach ($data as $value) {
                $dataEspPricing[] = [
                    'range' => $value->range,
                    'percent' => $value->percent,
                    'freight' => $value->freight,
                    'product_id' => $productId
                ];
            }

            $result = EspPricing::insert($dataEspPricing);
        }

        return $result;
    }
}
