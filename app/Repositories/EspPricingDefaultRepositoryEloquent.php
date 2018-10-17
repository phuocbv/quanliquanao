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
use Laraspace\Models\EspPricingDefault;
use Laraspace\Repositories\Contracts\EspPricingDefaultRepositoryInterface;
use Laraspace\Repositories\Contracts\EspPricingRepositoryInterface;

class EspPricingDefaultRepositoryEloquent extends BaseRepository implements EspPricingDefaultRepositoryInterface
{
    public function __construct(EspPricingDefault $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }
}
