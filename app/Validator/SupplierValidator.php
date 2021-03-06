<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 13/10/2018
 * Time: 20:41
 */
namespace Laraspace\Validator;

use \Prettus\Validator\LaravelValidator;
use Prettus\Validator\Contracts\ValidatorInterface;

class SupplierValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|unique:suppliers',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|unique:suppliers,name,:id'
        ]
    ];

    protected $messages = [
        'name.required' => 'Không nhập tên',
        'name.unique' => 'Tên đã được dùng'
    ];
}