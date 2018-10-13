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
                                <button class="btn btn-info">{{ trans('supplier_index.button_add') }}</button>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">

                        <table id="responsive-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ trans('supplier_index.table.id') }}</th>
                                <th>{{ trans('supplier_index.table.name') }}</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>{{ trans('supplier_index.table.id') }}</th>
                                <th>{{ trans('supplier_index.table.name') }}</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach( $suppliers as $value)
                                <tr>
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->name }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection