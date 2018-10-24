<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:25
 */

namespace Laraspace\Repositories;

use Laraspace\Models\Field;
use Laraspace\Models\Supplier;
use Laraspace\Models\SupplierField;
use Laraspace\Repositories\Contracts\SupplierRepositoryInterface;
use Illuminate\Support\Facades\DB;

class SupplierRepositoryEloquent extends BaseRepository implements SupplierRepositoryInterface
{
    public function __construct(Supplier $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function createSupplier($data)
    {
        try {
            DB::beginTransaction();

            $supplier = $this->findWhere([
                'name' => $data['name']
            ])->first();

            if (!$supplier) {
                $supplier = $this->create([
                    'name' => $data['name']
                ]);
            }

            $fields = collect([]);

            $fieldRequire = config('setting.field_require');
            $fields->push($fieldRequire);

            if (isset($data['field'])) {
                $fieldAddNew = $data['field'];
                $fields->push($fieldAddNew);
            }

            $fields = $fields->collapse()->all();

            foreach ($fields as $item) {
                $field = Field::where([
                    'name' => $item
                ])->first();

                if (!$field) {
                    $field = Field::create([
                        'name' => $item
                    ]);
                }

                SupplierField::create([
                    'supplier_id' => $supplier->id,
                    'field_id' => $field->id
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function updateSupplier($data, $supplierId)
    {
        try {
            DB::beginTransaction();
            $supplier = $this->find($supplierId);

            if (!$supplier) {
                DB::rollBack();
                return false;
            }

            $supplier->name = $data['name'];
            $supplier->save();

            $supplier->supplierFields()->delete();

            $fields = collect([]);

            $fieldRequire = config('setting.field_require');
            $fields->push($fieldRequire);

            if (isset($data['field'])) {
                $fieldAddNew = $data['field'];
                $fields->push($fieldAddNew);
            }

            $fields = $fields->collapse()->all();

            foreach ($fields as $item) {
                $field = Field::where([
                    'name' => $item
                ])->first();

                if (!$field) {
                    $field = Field::create([
                        'name' => $item
                    ]);
                }

                SupplierField::create([
                    'supplier_id' => $supplier->id,
                    'field_id' => $field->id
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
