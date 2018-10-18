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
use Laraspace\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Support\Facades\DB;

class ProductRepositoryEloquent extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
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
}
