@extends('admin.layouts.layout-basic')

@section('content')
    <div class="main-content">
        <div class="page-header">
            <h3 class="page-title">Supplier</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Supplier</li>
            </ol>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6>{{ trans('supplier_index.title') }}</h6>
                            </div>
                            <div class="col-sm-6" align="right" style="padding-right: 50px">
                                <button class="btn btn-info" id="btnShowModalAddSupplier">
                                    {{ trans('supplier_index.button_add') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="responsive-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ trans('supplier_index.table.id') }}</th>
                                <th>{{ trans('supplier_index.table.name') }}</th>
                                <th>{{ trans('index.edit') }}</th>
                            </tr>
                            </thead>
                            <tbody id="view-data">
                            @include('admin.item.suppliers.index')
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal add supplier -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('supplier_index.modal.title') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">{{ trans('supplier_index.modal.name') }}</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="{{ trans('supplier_index.modal.name') }}">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('index.modal.btn_close') }}</button>
                    <button type="button" class="btn btn-primary" id="btn-add-supplier">{{ trans('index.modal.btn_add') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal edit supplier -->
    <div class="modal fade" id="editSupplierModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"></div>
@endsection

@section('scripts')
    <script>
        let urlAddSupplier = '{{ route('admin.suppliers.store') }}';
        let urlEditSupplier = '{{ route('admin.suppliers.getSupplier') }}';
        let urlUpdateSupplier = '{{ route('admin.suppliers.updateSupplier') }}';
    </script>
    <script src="{{asset('/assets/admin/js/suppliers/index.js')}}"></script>
@endsection