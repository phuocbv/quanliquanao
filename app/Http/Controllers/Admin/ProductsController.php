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
use Laraspace\Repositories\Contracts\ProductRepositoryInterface;
use Laraspace\Repositories\Contracts\SizeRepositoryInterface;
use Laraspace\Repositories\Contracts\SupplierRepositoryInterface;
use Laraspace\Validator\SupplierValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\Exceptions\ValidatorException;

class ProductsController extends Controller
{
    protected $supplierRepository;
    protected $brandRepository;
    protected $colorRepository;
    protected $sizeRepository;
    protected $categoryRepository;
    protected $productRepository;

    public function __construct(
        SupplierRepositoryInterface $supplierRepository,
        BrandRepositoryInterface $brandRepository,
        ColorRepositoryInterface $colorRepository,
        SizeRepositoryInterface $sizeRepository,
        CategoryRepositoryInterface $categoryRepository,
        ProductRepositoryInterface $productRepository
    )
    {
        $this->supplierRepository = $supplierRepository;
        $this->brandRepository = $brandRepository;
        $this->colorRepository = $colorRepository;
        $this->sizeRepository = $sizeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        $input = $request->only('brand', 'category', 'gender', 'color', 'size');
        $listProductIdCategory = collect([]);
        $listProductIdColor = collect([]);
        $listProductIdSize = collect([]);

        //
        if (isset($input['category']) && $input['category'] != 0) {
            $category = $this->categoryRepository->find(trim($input['category']));
            if ($category) {
                $productCategories = $category->productCategories;
                $listProductIdCategory->push($productCategories->pluck('product_id'));
            }
        }

        //get list product id of color
        if (isset($input['color'])) {
            $arrColorId = explode(config('setting.delimiter'), $input['color']);
            $arrColorId = trimElementInArray($arrColorId);
            $colors = $this->colorRepository->findWhereIn('id', $arrColorId)->get();

            $colors->each(function ($item) use ($listProductIdColor) {
                $listProductIdColor->push($item->productColors->pluck('product_id'));
            });
        }

        //get list product id of size
        if (isset($input['size'])) {
            $arrSizeId = explode(config('setting.delimiter'), $input['size']);
            $arrSizeId = trimElementInArray($arrSizeId);
            $sizes = $this->sizeRepository->findWhereIn('id', $arrSizeId)->get();

            $sizes->each(function ($item) use ($listProductIdSize) {
                $listProductIdSize->push($item->productSizes->pluck('product_id'));
            });
        }

        $brands = $this->brandRepository->all();
        $colors = $this->colorRepository->all();
        $sizes = $this->sizeRepository->all();
        $categories = $this->categoryRepository->all();

        $products = $this->productRepository->searchProduct([
            'listProductIdCategory' => $listProductIdCategory->collapse()->unique()->values()->all(),
            'listProductIdColor' => $listProductIdColor->collapse()->unique()->values()->all(),
            'listProductIdSize' => $listProductIdSize->collapse()->unique()->values()->all(),
            'where' => $input
        ])->get();

        return view('admin.products.index', [
            'brands' => $brands,
            'colors' => $colors,
            'sizes' => $sizes,
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->only('name');
        try {
            $this->supplierValidator->with($input)->passesOrFail( ValidatorInterface::RULE_CREATE);
            $supplier = $this->supplierRepository->create($input);
            return $this->response(true, $supplier);
        } catch (ValidatorException $e) {
            return $this->response(false, null, $e->getMessageBag()->all());
        }
    }

    public function getSupplier(Request $request)
    {
        $input = $request->only('id');
        $supplier = $this->supplierRepository->find($input['id']);

        if (!$supplier) {
            return $this->response(false, null, [trans('supplier_index.not_found_supplier')]);
        }

        $view = view('admin.item.suppliers.edit', [
            'supplier' => $supplier
        ])->render();
        return $this->response(true, $view);
    }

    /**
     * update supplier
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSupplier(Request $request)
    {
        $input = $request->only('id', 'name');
        try {
            $this->supplierValidator->setId($input['id'])
                ->with($input)->passesOrFail( ValidatorInterface::RULE_UPDATE);
            $supplier = $this->supplierRepository->update($input, $input['id']);
            return $this->response(true, $supplier);
        } catch (ValidatorException $e) {
            return $this->response(false, null, $e->getMessageBag()->all());
        }
    }
}