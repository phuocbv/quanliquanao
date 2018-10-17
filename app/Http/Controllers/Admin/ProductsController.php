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

class ProductsController extends Controller
{
    protected $supplierRepository;
    protected $brandRepository;
    protected $colorRepository;
    protected $sizeRepository;
    protected $categoryRepository;
    protected $productRepository;
    protected $espPricingDefaultRepository;

    public function __construct(
        SupplierRepositoryInterface $supplierRepository,
        BrandRepositoryInterface $brandRepository,
        ColorRepositoryInterface $colorRepository,
        SizeRepositoryInterface $sizeRepository,
        CategoryRepositoryInterface $categoryRepository,
        ProductRepositoryInterface $productRepository,
        EspPricingDefaultRepositoryInterface $espPricingDefaultRepository
    )
    {
        $this->supplierRepository = $supplierRepository;
        $this->brandRepository = $brandRepository;
        $this->colorRepository = $colorRepository;
        $this->sizeRepository = $sizeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
        $this->espPricingDefaultRepository = $espPricingDefaultRepository;
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

    public function create()
    {
        $espPricingDefaults = $this->espPricingDefaultRepository->get(['range', 'percent', 'freight']);
        $sizes = $this->sizeRepository->all();
        $colors = $this->colorRepository->all();
        $brands = $this->brandRepository->all();
        $categories = $this->categoryRepository->all();
        $suppliers = $this->supplierRepository->all();

        return view('admin.products.add', [
            'espPricingDefaults' => $espPricingDefaults,
            'sizes' => $sizes,
            'colors' => $colors,
            'brands' => $brands,
            'categories' => $categories,
            'suppliers' => $suppliers
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->only('product_name', 'product_code', 'supplier', 'brand', 'category', 'gender', 'weight', 'description', 'size', 'color', 'supplier_pricing', 'esp_pricing');

        try {
            //validate

            //process create product
            $this->productRepository->saveProduct($input);
            return redirect()->route('admin.products');
        } catch (ValidatorException $e) {
            return $e->getMessageBag();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        $espPricingDefaults = $this->espPricingDefaultRepository->get(['range', 'percent', 'freight']);
        $sizes = $this->sizeRepository->all();
        $colors = $this->colorRepository->all();
        $brands = $this->brandRepository->all();
        $categories = $this->categoryRepository->all();
        $suppliers = $this->supplierRepository->all();

        $product = $this->productRepository->find($id);

        return view('admin.products.edit', [
            'espPricingDefaults' => $espPricingDefaults,
            'sizes' => $sizes,
            'colors' => $colors,
            'brands' => $brands,
            'categories' => $categories,
            'suppliers' => $suppliers,
            'product' => $product
        ]);
    }

    /**
     * update product
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $input = $request->only('product_id', 'product_name', 'product_code', 'supplier', 'brand', 'category', 'gender', 'weight', 'description', 'size', 'color', 'supplier_pricing', 'esp_pricing');
        try {
            //validate

            $this->productRepository->updateProduct($input, $input['product_id']);
            return redirect()->route('admin.products.edit', ['id' => $input['product_id']]);
        } catch (ValidatorException $e) {
            return $e->getMessageBag();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}