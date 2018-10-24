@extends('admin.layouts.layout-basic')

@section('content')
    <div class="main-content">
        <div class="page-header">
            <h3 class="page-title">Supplier</h3>
            {{--<ol class="breadcrumb">--}}
            {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
            {{--<li class="breadcrumb-item active">Product</li>--}}
            {{--</ol>--}}
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h6>Add Supplier</h6>
                    </div>
                    <div class="card-body">
                        <form class="row" action="{{ route('admin.suppliers.store') }}" method="post" id="formAddSupplier">
                            <input type="hidden" name="_token" value="{{ csrf_token()  }}">
                            <div class="col-md-12">
                                <h5 class="section-semi-title">BOCINI V-Neck Sports Shirt</h5>
                                <div class="form-group">
                                    <label for="supplierName">Supplier Name</label>
                                    <input type="type" class="form-control" id="supplierName" name="name" placeholder="Supplier Name" value="">
                                </div>

                                <div class="form-group">
                                    <label for="supplierName">Require Field</label>
                                </div>

                                @foreach($fieldRequire as $item)
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <input class="form-control" value="{{ $item }}" disabled>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="form-group">
                                    <label for="supplierName">Field</label>
                                </div>
                                <span id="listAddField"></span>

                                <div class="form-group">
                                    <button class="btn btn-success col-sm-12" type="button" id="btnAddField">Add Field</button>
                                </div>

                                <button class="btn btn-primary" type="submit">Add Supplier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let urlLoadEspPricingDefault = '{{ route('admin.espPricing') }}';
    </script>
    <script src="{{asset('/assets/admin/js/suppliers/add.js')}}"></script>
@endsection