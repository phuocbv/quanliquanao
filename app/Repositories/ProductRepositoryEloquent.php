<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:25
 */

namespace Laraspace\Repositories;

use Laraspace\Models\Brand;
use Laraspace\Models\EspPricing;
use Laraspace\Models\Product;
use Laraspace\Models\ProductCategory;
use Laraspace\Models\ProductColor;
use Laraspace\Models\ProductSize;
use Laraspace\Models\SupplierPricing;
use Laraspace\Repositories\Contracts\BrandRepositoryInterface;
use Laraspace\Repositories\Contracts\CategoryRepositoryInterface;
use Laraspace\Repositories\Contracts\EspPricingRepositoryInterface;
use Laraspace\Repositories\Contracts\ProductCategoryRepositoryInterface;
use Laraspace\Repositories\Contracts\ProductColorRepositoryInterface;
use Laraspace\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Laraspace\Repositories\Contracts\ProductSizeRepositoryInterface;
use Laraspace\Repositories\Contracts\SupplierPricingRepositoryInterface;
use Laraspace\Repositories\Contracts\SupplierRepositoryInterface;

class ProductRepositoryEloquent extends BaseRepository implements ProductRepositoryInterface
{
    protected $productSizeRepository;
    protected $productColorRepository;
//    protected $productCategoryRepository;
    protected $espPricingRepository;
    protected $supplierPricingRepository;
    protected $supplierRepository;
    protected $brandRepository;
    protected $categoryRepository;

    public function __construct
    (
        Product $model,
        ProductSizeRepositoryInterface $productSizeRepository,
        ProductColorRepositoryInterface $productColorRepository,
//        ProductCategoryRepositoryInterface $productCategoryRepository,
        EspPricingRepositoryInterface $espPricingRepository,
        SupplierPricingRepositoryInterface $supplierPricingRepository,
        SupplierRepositoryInterface $supplierRepository,
        BrandRepositoryInterface $brandRepository,
        CategoryRepositoryInterface $categoryRepository
    )
    {
        parent::__construct($model);
        $this->productColorRepository = $productColorRepository;
        $this->productSizeRepository = $productSizeRepository;
//        $this->productCategoryRepository = $productCategoryRepository;
        $this->espPricingRepository = $espPricingRepository;
        $this->supplierPricingRepository = $supplierPricingRepository;
        $this->supplierRepository = $supplierRepository;
        $this->brandRepository = $brandRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll()
    {
        return $this->all()->sortByDesc('id');
    }

    public function searchProduct($condition = [])
    {
        $listProductIdCategory = $condition['listProductIdCategory'];
        $listProductIdColor = $condition['listProductIdColor'];
        $listProductIdSize = $condition['listProductIdSize'];

        $where = $condition['where'];
        $arrCondition = [];

        if (isset($where['gender']) && $where['gender'] != 0) {
            $arrCondition['gender'] = $where['gender'];
        }

        if (isset($where['brand'])) {
            $arrCondition['brand_id'] = $where['brand'];
        }

        $result = $this->findWhere($arrCondition);

        if (isset($where['category'])) {
            $result = $result->whereIn('id', $listProductIdCategory);
        }

        if (isset($where['color']) && $where['color'] != '') {
            $result = $result->whereIn('id', $listProductIdColor);
        }

        if (isset($where['size']) && $where['size'] != '') {
            $result = $result->whereIn('id', $listProductIdSize);
        }

        return $result;
    }

    public function saveProduct($input = [])
    {
        try {
            DB::beginTransaction();

            $product = $this->create([
                'code' => $input['product_code'],
                'name' => $input['product_name'],
                'weight' => $input['weight'],
                'gender' => $input['gender'],
                'description' => $input['description'],
                'supplier_id' => $input['supplier'],
                'brand_id' => $input['brand'],
            ]);

            if (!$product) {
                DB::rollBack();
                return false;
            }

            $productCategory = ProductCategory::create([
                'product_id' => $product->id,
                'category_id' => $input['category']
            ]);

            if (!$productCategory) {
                DB::rollBack();
                return false;
            }

            //process size
            if (isset($input['size'])) {
                $arrSize = $input['size'];
                $dataSize = [];

                foreach ($arrSize as $value) {
                    $dataSize[] = [
                        'product_id' => $product->id,
                        'size_id' => $value
                    ];
                }

                $result = ProductSize::insert($dataSize);

                if (!$result) {
                    DB::rollBack();
                    return false;
                }
            }

            //process color
            if (isset($input['color'])) {
                $arrColor = $input['color'];
                $dataColor = [];

                foreach ($arrColor as $value) {
                    $dataColor[] = [
                        'product_id' => $product->id,
                        'color_id' => $value
                    ];
                }

                $result = ProductColor::insert($dataColor);

                if (!$result) {
                    DB::rollBack();
                    return false;
                }
            }

            //process esp_pricing
            if ($input['esp_pricing']) {
                $listEspPricing = json_decode($input['esp_pricing']);
                $dataEspPricing = [];

                foreach ($listEspPricing as $value) {
                    $dataEspPricing[] = [
                        'range' => $value->range,
                        'percent' => $value->percent,
                        'freight' => $value->freight,
                        'product_id' => $product->id
                    ];
                }

                $result = EspPricing::insert($dataEspPricing);

                if (!$result) {
                    DB::rollBack();
                    return false;
                }
            }

            //process supplier_pricing
            if ($input['supplier_pricing']) {
                $listSupplierPricing = json_decode($input['supplier_pricing']);
                $dataSupplierPricing = [];

                foreach ($listSupplierPricing as $value) {
                    $dataSupplierPricing[] = [
                        'min' => $value->min,
                        'max' => $value->max,
                        'unit_price' => $value->unit_price,
                        'product_id' => $product->id
                    ];
                }

                $result = SupplierPricing::insert($dataSupplierPricing);

                if (!$result) {
                    DB::rollBack();
                    return false;
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $product;
    }

    public function updateProduct($input = [], $id)
    {
        try {
            DB::beginTransaction();

            $product = $this->update([
                'code' => $input['product_code'],
                'name' => $input['product_name'],
                'weight' => $input['weight'],
                'gender' => $input['gender'],
                'description' => $input['description'],
                'supplier_id' => $input['supplier'],
                'brand_id' => $input['brand'],
            ], $id);

            if (!$product) {
                DB::rollBack();
                return false;
            }

            $product = $this->find($id);

            //process category
            $product->productCategories()->delete();

            $productCategory = ProductCategory::create([
                'product_id' => $product->id,
                'category_id' => $input['category']
            ]);

            if (!$productCategory) {
                DB::rollBack();
                return false;
            }

            //process size
            $product->productSizes()->delete();
            if (isset($input['size'])) {
                $arrSize = $input['size'];
                $dataSize = [];

                foreach ($arrSize as $value) {
                    $dataSize[] = [
                        'product_id' => $product->id,
                        'size_id' => $value
                    ];
                }

                $result = ProductSize::insert($dataSize);

                if (!$result) {
                    DB::rollBack();
                    return false;
                }
            }


            //process color
            $product->productColors()->delete();
            if (isset($input['color'])) {
                $arrColor = $input['color'];
                $dataColor = [];

                foreach ($arrColor as $value) {
                    $dataColor[] = [
                        'product_id' => $product->id,
                        'color_id' => $value
                    ];
                }

                $result = ProductColor::insert($dataColor);

                if (!$result) {
                    DB::rollBack();
                    return false;
                }
            }

            //process esp_pricing
            if ($input['esp_pricing']) {
                $product->espPricings()->delete();
                $listEspPricing = json_decode($input['esp_pricing']);
                $dataEspPricing = [];

                foreach ($listEspPricing as $value) {
                    $dataEspPricing[] = [
                        'range' => $value->range,
                        'percent' => $value->percent,
                        'freight' => $value->freight,
                        'product_id' => $product->id
                    ];
                }

                $result = EspPricing::insert($dataEspPricing);

                if (!$result) {
                    DB::rollBack();
                    return false;
                }
            }

            //process supplier_pricing
            if ($input['supplier_pricing']) {
                $product->supplierPricings()->delete();
                $listSupplierPricing = json_decode($input['supplier_pricing']);
                $dataSupplierPricing = [];

                foreach ($listSupplierPricing as $value) {
                    $dataSupplierPricing[] = [
                        'min' => $value->min,
                        'max' => $value->max,
                        'unit_price' => $value->unit_price,
                        'product_id' => $product->id
                    ];
                }

                $result = SupplierPricing::insert($dataSupplierPricing);

                if (!$result) {
                    DB::rollBack();
                    return false;
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function importProduct($dataImports)
    {
        try {
            DB::beginTransaction();

            foreach ($dataImports as $dataImport) {
                $supplier = $this->supplierRepository->findWhere([
                    'name' => trim($dataImport['supplier_name'])
                ])->first();

                if (!$supplier) {
                    DB::rollBack();
                    return false;
                }

                $brand = $this->brandRepository->findWhere([
                    'name' => trim($dataImport['brand_name'])
                ])->first();

                if (!$brand) {
                    DB::rollBack();
                    return false;
                }

                //process create product
                $product = $this->createProduct([
                    'product_code' => $dataImport['product_code'],
                    'product_name' => $dataImport['product_name'],
                    'weight' => 0,
                    'gender' => 0,
                    'description' => $dataImport['product_description'],
                    'supplier' => $supplier->id,
                    'brand' => $brand->id
                ]);

                if (!$product) {
                    DB::rollBack();
                    return false;
                }

                //process create product category
                $category = $this->categoryRepository->findOrCreate($dataImport);

                if (!$category) {
                    DB::rollBack();
                    return false;
                }

                $productCategory = ProductCategory::create([
                    'product_id' => $product->id,
                    'category_id' => $category->id
                ]);

                if (!$productCategory) {
                    DB::rollBack();
                    return false;
                }

                //process size of product
                if (isset($dataImport['product_size'])) {
                    $arrSize = explode('|', trim($dataImport['product_size']));
                    $this->productSizeRepository->findOrInsertMany($arrSize, $product->id);
                }

                //process color of product
                if (isset($dataImport['colours_available_supplier'])) {
                    $arrColor = explode('|', trim($dataImport['colours_available_supplier']));
                    $this->productColorRepository->findOrInsertMany($arrColor, $product->id);

                }
//
//                //process esp_pricing
//                if ($dataImport['esp_pricing']) {
//                    $listEspPricing = json_decode($dataImport['esp_pricing']);
//                    $result = $this->espPricingRepository->insertMany($listEspPricing, $product->id);
//
//                    if (!$result) {
//                        DB::rollBack();
//                        return false;
//                    }
//                }
//
                //process supplier_pricing
                $dataSupplierPricing = [];

                array_push($dataSupplierPricing, [
                    'min' => trim($dataImport['qty_1']),
                    'unit_price' => trim($dataImport['price_1']),
                    'product_id' => $product->id
                ]);

                array_push($dataSupplierPricing, [
                    'min' => trim($dataImport['qty_2']),
                    'unit_price' => trim($dataImport['price_2']),
                    'product_id' => $product->id
                ]);

                array_push($dataSupplierPricing, [
                    'min' => trim($dataImport['qty_3']),
                    'unit_price' => trim($dataImport['price_3']),
                    'product_id' => $product->id
                ]);

                array_push($dataSupplierPricing, [
                    'min' => trim($dataImport['qty_4']),
                    'unit_price' => trim($dataImport['price_4']),
                    'product_id' => $product->id
                ]);

                $result = $this->supplierPricingRepository->insertManyNotMax($dataSupplierPricing, $product->id);

                if (!$result) {
                    DB::rollBack();
                    return false;
                }

            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }

    private function createProduct($input = [])
    {
        $product = $this->create([
            'code' => $input['product_code'],
            'name' => $input['product_name'],
            'weight' => $input['weight'],
            'gender' => $input['gender'],
            'description' => $input['description'],
            'supplier_id' => $input['supplier'],
            'brand_id' => $input['brand'],
        ]);

        return $product;
    }
}
