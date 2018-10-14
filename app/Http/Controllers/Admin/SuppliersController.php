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
use Laraspace\Repositories\Contracts\SupplierRepositoryInterface;
use Laraspace\Validator\SupplierValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\Exceptions\ValidatorException;

class SuppliersController extends Controller
{
    protected $supplierRepository;
    protected $supplierValidator;

    public function __construct(
        SupplierRepositoryInterface $supplierRepository,
        SupplierValidator $supplierValidator
    )
    {
        $this->supplierRepository = $supplierRepository;
        $this->supplierValidator = $supplierValidator;
    }

    public function index()
    {
        $suppelier = $this->supplierRepository->all();

        return view('admin.suppliers.index', [
            'suppliers' => $suppelier,
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