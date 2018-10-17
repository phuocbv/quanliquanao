<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 13/10/2018
 * Time: 12:11
 */
namespace Laraspace\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laraspace\Http\Controllers\Controller;
use Laraspace\Repositories\Contracts\BrandRepositoryInterface;
use Laraspace\Repositories\Contracts\CategoryRepositoryInterface;
use Laraspace\Repositories\Contracts\ColorRepositoryInterface;
use Laraspace\Repositories\Contracts\EspPricingDefaultRepositoryInterface;
use Laraspace\Repositories\Contracts\ProductRepositoryInterface;
use Laraspace\Repositories\Contracts\SizeRepositoryInterface;
use Laraspace\Repositories\Contracts\SupplierRepositoryInterface;
use Laraspace\Validator\SupplierValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\Exceptions\ValidatorException;

class EspPricingsController extends Controller
{
    protected $espPricingDefaultRepository;

    public function __construct(EspPricingDefaultRepositoryInterface $espPricingDefaultRepository)
    {
        $this->espPricingDefaultRepository = $espPricingDefaultRepository;
    }

    public function getEspDefault()
    {
        $listEspPricingDefault = $this->espPricingDefaultRepository->all();

        return $this->response(true, $listEspPricingDefault);
    }
}