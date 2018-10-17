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
}
