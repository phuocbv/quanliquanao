<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:25
 */

namespace Laraspace\Repositories;

use Laraspace\Models\Attribute;
use Laraspace\Models\AttributeValue;
use Laraspace\Models\ProductAttribute;
use Laraspace\Repositories\Contracts\AttributeValueRepositoryInterface;

class AttributeValueRepositoryEloquent extends BaseRepository implements AttributeValueRepositoryInterface
{
    public function __construct(
        AttributeValue $model
    )
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function insertListAttribute($dataImport, $fields, $productId)
    {
        $dataImport = $dataImport->toArray();

        foreach ($dataImport as $key => $value) {
            if (!$fields->contains($key)) continue;

            $attribute = Attribute::where([
                'name' => $key
            ])->first();

            if (!$attribute) {
                $attribute = Attribute::create([
                    'name' => $key
                ]);
            }

            $attributeValue = $this->create([
                'value' => $value,
                'attribute_id' => $attribute->id
            ]);

            ProductAttribute::create([
                'product_id' => $productId,
                'attribute_value_id' => $attributeValue->id
            ]);
        }
    }
}
