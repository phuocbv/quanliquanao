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
                        <h6>Edit Product</h6>
                    </div>
                    <div class="card-body">
                        @if ($product)
                        <form class="row" action="{{ route('admin.products.updateProduct') }}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token()  }}">
                            <input type="hidden" name="product_id" value="{{ $product->id  }}">
                            <div class="col-md-6">
                                <h5 class="section-semi-title">BOCINI V-Neck Sports Shirt</h5>
                                <div class="form-group">
                                    <label for="productName">Product Name</label>
                                    <input type="type" class="form-control" id="productName" name="product_name" placeholder="Product Name" value="{{ $product->name }}">
                                    {{--<small id="emailHelp" class="form-text text-muted">We'll never share your email with--}}
                                        {{--anyone else.--}}
                                    {{--</small>--}}
                                </div>
                                <div class="form-group">
                                    <label for="productCode">Product Code</label>
                                    <input type="type" class="form-control" id="productCode" name="product_code" placeholder="Product code" value="{{ $product->code }}">
                                </div>
                                <div class="form-group">
                                    <label for="supplier">Supplier</label>
                                    <select class="form-control col-md-12" id="supplier" name="supplier">
                                        <option value="0">------Select Supplier------</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ $supplier->id == $product->supplier_id ? 'selected' : ''}}>{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6">
                                        <label for="brand">Brand</label>
                                        <select class="form-control col-md-12" id="brand" name="brand">
                                            <option value="0">-----Select Brand-----</option>
                                            @foreach($brands as $brand)
                                                <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : ''}}>{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="category">Category</label>
                                        <select class="form-control col-md-12" id="category" name="category">
                                            <option value="0">------Select Category------</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ $category->id == $product->categories[0]->id ? 'selected' : ''}}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2">Gender</label>
                                    <div class="col-sm-10">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" value="{{ config('setting.gender.male') }}"
                                                   {{ $product->gender == config('setting.gender.male') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="checkMale">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" value="{{ config('setting.gender.female') }}"
                                                    {{ $product->gender == config('setting.gender.female') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="checkFemale">Female</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label" for="weight">Weight</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="weight" name="weight" placeholder="Weight" value="{{ $product->weight }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <div>
                                        <textarea class="form-control" id="description" name="description" rows="3">{{ $product->description }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2">Sizes</label>
                                    <div class="col-sm-10">
                                        @foreach($sizes as $size)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                       value="{{ $size->id }}" name="size[]" {{ checkBoxColor($product, $size->id) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="inlineCheckbox1">{{ $size->size }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2">Colors</label>
                                    <div class="col-sm-10">
                                        @foreach($colors as $color)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="colorCheckbox{{$color->id}}"
                                                       value="{{ $color->id }}" name="color[]" {{ checkBoxColor($product, $color->id) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="colorCheckbox{{ $color->id }}">{{ $color->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <button class="btn btn-primary">Edit</button>
                            </div>
                            <div class="col-sm-6">
                                <div style="position: relative">
                                    <h5 class="section-semi-title">SUPPLIER PRICING</h5>
                                    <div style="position: absolute; top: -2px; right: 25px">
                                        <i class="icon-im icon-im-plus" id="addSupplierPricing" style="cursor: pointer"></i>
                                    </div>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Min</th>
                                        <th>Max</th>
                                        <th>Unit Price</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody id="table_supplier_pricing">
                                        @foreach($product->supplierPricings as $supplierPricing)
                                            <tr>
                                                <td class="min">{{ $supplierPricing->min }}</td>
                                                <td class="max">{{ $supplierPricing->max }}</td>
                                                <td class="unit_price">{{ $supplierPricing->unit_price }}</td>
                                                <td>
                                                    <i class="icon-im icon-im-pencil" style="cursor: pointer"></i>
                                                    <i class="icon-im icon-im-bin" style="cursor: pointer; margin-left: 10px"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <input type="hidden" value="{{ ($product->supplierPricings) }}" name="supplier_pricing" id="hiddenSupplierPricing">

                                <div style="position: relative">
                                    <h5 class="section-semi-title">ESP PRICING</h5>
                                    <div style="position: absolute; top: -2px; right: 25px">
                                        <i class="icon-im icon-im-plus" style="margin-right: 10px; cursor: pointer" id="addEspPricing"></i>
                                        <i class="icon-im icon-im-spinner9" style="cursor: pointer" id="loadEspPricingDefault"></i>
                                    </div>
                                </div>

                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Range</th>
                                        <th>%</th>
                                        <th>Freight</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody id="table-esp-pricing">
                                    @if ($product->espPricings->count() > 0)
                                        @php
                                            $espPricings = $product->espPricings;
                                        @endphp
                                        @foreach($product->espPricings as $espPricing)
                                            <tr>
                                                <td class="range">{{ $espPricing->range }}</td>
                                                <td class="percent">{{ $espPricing->percent }}</td>
                                                <td class="freight">{{ $espPricing->freight }}</td>
                                                <td>
                                                    <i class="icon-im icon-im-pencil" style="cursor: pointer"></i>
                                                    <i class="icon-im icon-im-bin" style="cursor: pointer; margin-left: 10px"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @php
                                            $espPricings = $espPricingDefaults;
                                        @endphp
                                        @foreach($espPricingDefaults as $espPricingDefault)
                                            <tr>
                                                <td class="range">{{ $espPricingDefault->range }}</td>
                                                <td class="percent">{{ $espPricingDefault->percent }}</td>
                                                <td class="freight">{{ $espPricingDefault->freight }}</td>
                                                <td>
                                                    <i class="icon-im icon-im-pencil" style="cursor: pointer"></i>
                                                    <i class="icon-im icon-im-bin" style="cursor: pointer; margin-left: 10px"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                                <input type="hidden" value="{{ json_encode($espPricings) }}" name="esp_pricing" id="hiddenEspPricing">
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- modal add supplier pricing -->
    <div class="modal fade" id="addSupplierPricingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Supplier Pricing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="min">Min</label>
                        <input type="text" class="form-control" id="min" placeholder="Min">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="max">Max</label>
                        <input type="text" name="name" class="form-control" id="max" placeholder="Max">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="unit_price">Unit Price</label>
                        <input type="text" name="name" class="form-control" id="unit_price" placeholder="Unit Price">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('index.modal.btn_close') }}</button>
                    <button type="button" class="btn btn-primary" id="btn-add-supplier-pricing">{{ trans('index.modal.btn_add') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- modal add esp pricing -->
    <div class="modal fade" id="addEspPricingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Esp Pricing</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="range">Range</label>
                        <input type="text" class="form-control" id="range" placeholder="Range">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="percent">Percent(%)</label>
                        <input type="text" class="form-control" id="percent" placeholder="Percent">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="freight">Freight</label>
                        <input type="text" class="form-control" id="freight" placeholder="Freight">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('index.modal.btn_close') }}</button>
                    <button type="button" class="btn btn-primary" id="btn-add-esp-pricing">{{ trans('index.modal.btn_add') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let urlLoadEspPricingDefault = '{{ route('admin.espPricing') }}';
    </script>
    <script src="{{asset('/assets/admin/js/products/edit.js')}}"></script>
@endsection