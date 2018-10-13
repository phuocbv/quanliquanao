<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 19/09/2017
 * Time: 01:25
 */

namespace Laraspace\Repositories;

use Laraspace\Repositories\Contracts\UserRepositoryInterface;
use Laraspace\User;

class UserRepositoryEloquent extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getListUser()
    {
        return $this->all();
    }
}
