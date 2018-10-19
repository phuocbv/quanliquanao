@extends('admin.layouts.layout-basic')

@section('content')
    <div class="main-content">
        <div class="page-header">
            <h3 class="page-title">Product</h3>
            {{--<ol class="breadcrumb">--}}
                {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                {{--<li class="breadcrumb-item active">Product</li>--}}
            {{--</ol>--}}
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h6>Import Product</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.confirmImportProduct') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token()  }}">
                            <div class="form-row">
                                <div class="form-group col-md-4 row">
                                    <label for="supplier" class="col-md-3 col-form-label">Supplier</label>
                                    <select class="form-control col-md-8" id="brand" name="supplier" required="required">
                                        <option>--------Select Supplier---------</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="validatedCustomFile" required name="import_file">
                                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                        <div class="invalid-feedback">Example invalid custom file feedback</div>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <button class="btn btn-success" type="submit">Import</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if ($products)
            <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6>Product List</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="responsive-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Brand</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Weight</th>
                                <th>Colors</th>
                                <th>Gender</th>
                                <th>Sizes</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="view-data">
                                @foreach($products as $product)
                                    <tr>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="{{asset('/assets/admin/js/products/index.js')}}"></script>
@endsection