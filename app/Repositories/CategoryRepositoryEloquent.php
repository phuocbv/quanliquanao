<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:25
 */

namespace Laraspace\Repositories;

use Laraspace\Models\Category;
use Laraspace\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepositoryEloquent extends BaseRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getAll()
    {
        // TODO: Implement getAll() method.
    }

    public function findOrCreate($data = [])
    {
        $category = $this->findWhere([
            'name' => $data['categorisation']
        ])->first();

        if (!$category) {
            $category = $this->create([
                'name' => $data['categorisation']
            ]);
        }

        return $category;
    }
}
