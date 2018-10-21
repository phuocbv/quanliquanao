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
                        @include('admin.item.error')
                        <form action="{{ route('admin.confirmImportProduct') }}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token()  }}">
                            <div class="form-row">
                                <div class="form-group col-md-4 row">
                                    <label for="supplier" class="col-md-3 col-form-label">Supplier</label>
                                    <select class="form-control col-md-8" id="supplier" name="supplier" required="required">
                                        <option value="">--------Select Supplier---------</option>
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
                                    <button class="btn btn-success" type="submit">Upload</button>
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
                    <div class="card-body table-wrapper-scroll-y">
                        <table id="responsive-datatable" class="table table-striped table-bordered" width="100%">
                            <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Brand</th>
                                {{--<th>Product Description</th>--}}
                                <th>Colors</th>
                                <th>Sizes</th>
                                <th>Price Product Code</th>
                                {{--<th>URL</th>--}}
                            </tr>
                            </thead>
                            <tbody id="view-data">
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product['product_code'] }}</td>
                                        <td>{{ $product['product_name'] }}</td>
                                        <td>{{ $product['categorisation'] }}</td>
                                        <td>{{ $product['brand_name'] }}</td>
{{--                                        <td>{{ $product['product_description'] }}</td>--}}
                                        <td>{{ $product['colours_available_supplier'] }}</td>
                                        <td>{{ $product['product_size'] }}</td>
                                        <td>{{ $product['price_product_code'] }}</td>
{{--                                        <td>{{ $product['product_url'] }}</td>--}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-12" align="right">
                                <form action="{{ route('admin.completeImportProduct') }}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token()  }}">
                                    <button class="btn btn-success" type="submit">Import</button>
                                </form>
                            </div>
                        </div>
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