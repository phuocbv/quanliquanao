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
                        <h6>{{ trans('product_index.filter_product.title') }}</h6>
                    </div>
                    <div class="card-body">
                        <form action="" method="get">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="brand">{{ trans('product_index.filter_product.brand') }}</label>
                                    <select class="form-control" id="brand" name="brand">
                                        <option value="">All</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="category">{{ trans('product_index.filter_product.product_category') }}</label>
                                    <select class="form-control" id="category" name="category">
                                        <option value="">All</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="gender">Gender</label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="">All</option>
                                        <option value="0">Male</option>
                                        <option value="1">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <h5>{{ trans('product_index.filter_product.colors') }}</h5>
                                    @foreach($colors as $color)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="{{ $color->id }}" name="color"
                                                   value="{{ $color->id }}">
                                            <label class="form-check-label" for="{{ $color->id }}">{{ $color->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="form-group col-md-6">
                                    <h5>{{ trans('product_index.filter_product.sizes') }}</h5>
                                    @foreach($sizes as $size)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="{{ $size->id }}" name="size"
                                                   value="option1">
                                            <label class="form-check-label" for="{{ $size->id }}">{{ $size->size }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <button class="btn btn-primary">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-6">
                                <h6>Danh sách sản phẩm</h6>
                            </div>
                            <div class="col-sm-6" align="right" style="padding-right: 50px">
                                <a href="{{ route('admin.products.add') }}" class="btn btn-primary">
                                    {{ trans('supplier_index.button_add') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="responsive-datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>{{ trans('supplier_index.table.id') }}</th>
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
                                        <td>{{ $product->id }}</td>
                                        <td>{{ $product->brand->name }}</td>
                                        <td>{{ convertArrayObjectToString($product->categories) }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->weight }}</td>
                                        <td>{{ convertArrayObjectToString($product->colors) }}</td>
                                        <td>{{ trans('product_index.gender')[$product->gender] }}</td>
                                        <td>{{ convertArrayObjectToString($product->sizes, 'size') }}</td>
                                        <td>
                                            <a href="{{ route('admin.products.edit', ['id' => $product->id]) }}">
                                                <i class="icon-im icon-im-pencil"></i>
                                            </a>
                                        </td>
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