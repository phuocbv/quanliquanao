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
        $input = $request->only('name', 'field');

        try {
            //validate
            //$this->supplierValidator->with($input)->passesOrFail( ValidatorInterface::RULE_CREATE);

            $this->supplierRepository->createSupplier($input);
            //$supplier = $this->supplierRepository->create($input);
            return redirect()->route('admin.suppliers');
        } catch (ValidatorException $e) {
            return $e->getMessageBag()->all();
        }
    }

    public function create()
    {
        $fieldRequire = config('setting.field_require');

        return view('admin.suppliers.add', [
            'fieldRequire' => $fieldRequire
        ]);
    }

    public function edit($id)
    {
        $supplier = $this->supplierRepository->find($id);
        $fieldRequire = config('setting.field_require');

        return view('admin.suppliers.edit', [
            'supplier' => $supplier,
            'fieldRequire' => $fieldRequire
        ]);
    }

    public function getSupplier(Request $request)
    {
        $input = $request->only('name', 'field');
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
        $input = $request->only('id', 'name', 'field');

        try {
            //validate
//            $this->supplierValidator->setId($input['id'])
//                ->with($input)->passesOrFail( ValidatorInterface::RULE_UPDATE);

            $this->supplierRepository->updateSupplier($input, $input['id']);

            return redirect()->route('admin.suppliers.edit', ['id' => $input['id']]);
        } catch (ValidatorException $e) {
            return $e->getMessageBag()->all();
        }
    }
}