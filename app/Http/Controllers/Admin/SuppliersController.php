<?php
/**
 * Created by PhpStorm.
 * User: da
 * Date: 13/10/2018
 * Time: 12:11
 */
namespace Laraspace\Http\Controllers\Admin;

use Laraspace\Http\Controllers\Controller;
use Laraspace\Repositories\Contracts\SupplierRepositoryInterface;

class SuppliersController extends Controller
{
    protected $supplierRepository;

    public function __construct(SupplierRepositoryInterface $supplierRepository)
    {
        $this->supplierRepository = $supplierRepository;
    }

    public function index()
    {
        $suppelier = $this->supplierRepository->all();

        return view('admin.suppliers.index', [
            'suppliers' => $suppelier,
        ]);
    }
}