@extends('layouts.app')

@section('title', $item->name)

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                <span class="breadcrumb-item active">{{ $item->name }}</span>
            </div>
        </div>
    </div>
</div>
<!-- /page header -->

<!-- Content area -->
<div class="content">
    <!-- Form inputs -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">{{ $item->name }}</h5>
            <div class="header-elements">
                <a type="button" href="{{ route('item.index') }}" class="btn custom-btn-success"><i class="icon-circle-left2 mr-2"></i>Back</a>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('item.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Item Name</label>
                    <div class="col-lg-10">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Item Name" value="{{ old('name', $item->name) }}">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2 text-mandatory">Select Item Category</label>
                    <div class="col-lg-10">
                        <select name="item_category_id" class="form-control select-search @error('item_category_id') is-invalid @enderror">
                            <option value="">Selelct Item Category</option>
                            @foreach($itemCategories as $itemCategory)
                                <option value="{{ $itemCategory->id }}" {{ (old('item_category_id', $item->item_category_id)== $itemCategory->id) ? 'selected=selected': ''}}>{{ $itemCategory->name }}</option>
                            @endforeach
                        </select>
                        @error('item_category_id')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Costing Price</label>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </span>
                            <input type="number" name="costing_price" class="form-control" placeholder="Costing Price" value="{{ old('costing_price', $item->costing_price) }}">
                            @error('costing_price')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Selling Price</label>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </span>
                            <input type="number" name="selling_price" class="form-control" placeholder="Selling Price" value="{{ old('selling_price', $item->selling_price) }}">
                            @error('current_reading')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Average Costing Price</label>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </span>
                            <input type="number" name="average_costing_price" class="form-control" placeholder="Average Costing Price" readonly value="{{ old('average_costing_price', $item->average_costing_price) }}">
                            @error('average_costing_price')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Opening Stock</label>
                    <div class="col-lg-10">
                        <input type="number" name="opening_stock" class="form-control" placeholder="Opening Stock" readonly value="{{ old('opening_stock', $item->opening_stock) }}">
                        @error('opening_stock')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-lg-2">Current Stock</label>
                    <div class="col-lg-10">
                        <div class="input-group">
                            <input type="number" name="current_stock" class="form-control" placeholder="Current Stock" readonly value="{{ old('current_stock', $item->opening_stock) }}">
                            @error('current_stock')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <span class="input-group-prepend">
                                 <span class="input-group-text">Ltr</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-lg-12">
                        <button type="submit" class="btn btn-primary float-right">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /form inputs -->

</div>
<!-- /content area -->
@endsection

@push('js')
    <!-- Theme JS files -->
    <script src="{{ asset('assets/global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/forms/styling/switch.min.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/demo_pages/form_checkboxes_radios.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/demo_pages/form_inputs.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/pickers/anytime.min.js') }}"></script>
@endpush
