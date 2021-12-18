@extends('layouts.app')

@push('css')
    <!-- <link rel="stylesheet" href="{{ asset('assets/plugins/selectize/dist/css/selectize.bootstrap4.css') }}"> -->
@endpush

@section('title', 'New Purchase')

@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                    <span class="breadcrumb-item active">New Purchase</span>
                </div>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="card-body">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">New Purchase</h5>
            <div class="header-elements">
                <a type="button" href="{{ route('purchase.index') }}" class="btn custom-btn-success"><i class="icon-circle-left2 mr-2"></i>Back</a>
            </div>
        </div>
        <form method="POST"  action="{{ route('purchase.store') }}">
            @csrf

            <div class="row">
                <div class="col-md-4" >
                    <div class="form-group">
                        <label class="control-label">Select Supplier</label>
                        <a href="#" data-reload="false" data-title="Add Supplier" data-toggle="modal" data-target="#add_supplier" class="ajax-modal select2-add float-right"><i class="ti-plus"></i> Add New</a>
                        <select class="form-control select2-ajax" data-value="id" data-display="supplier_name" data-table="parties" data-where="1" name="party_id" id="party_id">
                            <option value="">Select Supplier</option>
                            @foreach($parties as $party)
                                <option value="{{ $party->id }}" {{ (old('party_id') == $party->id) ? 'selected=selected' : ''}}>{{ $party->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="inputPassword4" class="text-mandatory">Purchase Date</label>
                    <input type="text" name="purchase_date" class="form-control  @error('purchase_date') is-invalid @enderror" id="anytime-both" value="{{ old('purchase_date', date('d-m-Y g:i:s A', strtotime(now()))) }}">
                    @error('purchase_date')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">Vehicle Number</label>
                        <input type="text" class="form-control datepicker" id="vehicle_number" name="vehicle_number" value="{{ old('vehicle_number') }}" required>
                    </div>
                </div>


                <div class="col-md-3">
                    <div class="form-group select-product-container">
                        <label class="control-label">{{  ('Select Product') }}</label>
                        <select class="form-control select2-ajax" data-value="id" data-display="item_name" data-table="items" data-where="2" name="item" id="item_id" onchange="getProductPrice(this.value)">
                            <option value="">{{  ('Select Product') }}</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}" {{ (old('item_id') == $item->id) ? 'selected=selected' : ''}}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label for="item_id" class="control-label">{{  ('Unit Price') }}</label>
                        <input readonly type="text" class="form-control" name="unit_price" id="unit_price0" placeholder="Unit Price" />
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">{{  ('Quantity') }}</label>
                        <input type="text" class="form-control " name="quantity" id="quantity0" onkeyup="calc_total(0)"  />
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">{{  ('Discount') }}</label>
                        <input type="text" class="form-control " name="discount" id="discount0" onkeyup="calc_total(0)"  />
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">{{  ('Total') }}</label>
                        <input readonly type="text" class="form-control" name="total" id="total0" />
                    </div>
                </div>

                <div class="col-md-1">
                    <div class="form-group">
                        <label class="control-label">{{ ('Action ') }}</label>
                        <button type="button" onclick="add_row()" class="btn btn-primary">{{  ('Add') }}</button>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="order-table" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>{{  ('Name') }}</th>
                                <th class="text-right">{{  ('Unit Price') }}</th>
                                <th class="text-right wp-100">{{  ('Quantity') }}</th>
                                <th class="text-right wp-100">{{  ('Discount') }}</th>
                                <th class="text-right">{{  ('Sub Total') }}</th>
                                <th class="text-center">{{  ('Action') }}</th>
                            </tr>
                            </thead>

                            <tbody id="output">

                            </tbody>

                            <tfoot class="tfoot active">
                            <tr>
                                <th>{{  ('Total') }}</th>
                                <th class="text-right" id="unit-price"></th>
                                <th class="text-right" id="total_quantity">0</th>
                                <th class="text-right" id="total_discount">0</th>
                                <th class="text-right" id="grand_total">0</th>
                                <th class="text-center"></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!--End Order table -->



                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary float-right">{{  ('Save') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- add supplier modal -->
    <div id="add_supplier" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-danger text-center db_error" style="display:none;" id="db_error"></div>
                    <form action="{{ route('supplier.ajax-store') }}" method="POST" id="supplier_ajax_form">
                        @csrf
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2 text-mandatory">Supplier Name</label>
                            <div class="col-lg-10">
                                <input type="text" name="name" class="form-control" placeholder="Supplier Name" value="{{ old('name') }}">
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2 text-mandatory">Supplier Phone</label>
                            <div class="col-lg-10">
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Supplier Phone" value="{{ old('phone') }}">
                                <span class="text-danger error-text phone_error"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Supplier Email</label>
                            <div class="col-lg-10">
                                <input type="text" name="email" class="form-control" placeholder="Supplier Email" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Supplier Address</label>
                            <div class="col-lg-10">
                                <input type="text" name="address" class="form-control" placeholder="Supplier Address" value="{{ old('address') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Bank Name</label>
                            <div class="col-lg-10">
                                <input type="text" name="bank_name" class="form-control" placeholder="Bank Name" value="{{ old('bank_name') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Bank Branch</label>
                            <div class="col-lg-10">
                                <input type="text" name="bank_branch" class="form-control" placeholder="Bank Branch" value="{{ old('bank_branch') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Account Holder</label>
                            <div class="col-lg-10">
                                <input type="text" name="account_name" class="form-control" placeholder="Account Holder" value="{{ old('account_name') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Account Number</label>
                            <div class="col-lg-10">
                                <input type="text" name="account_number" class="form-control" placeholder="Account Number" value="{{ old('account_number') }}">
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
        </div>
    </div>
    <!-- /add supplier modal -->


    {{--    <select class="form-control d-none" id="tax-selector">--}}
    {{--        @foreach(App\Tax::where("company_id",company_id())->get() as $tax)--}}
    {{--            <option value="{{ $tax->id }}" data-tax-type="{{ $tax->type }}" data-tax-rate="{{ $tax->rate }}">{{ $tax->tax_name }} - {{ $tax->type =='percent' ? $tax->rate.' %' : $tax->rate }}</option>--}}
    {{--        @endforeach--}}
    {{--    </select>--}}

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
    <!-- <script src="{{ asset('assets/plugins/selectize/dist/js/standalone/selectize.js') }}"></script> -->
    <script src="{{ asset('assets/global_assets/js/demo_pages/form_inputs.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/pickers/anytime.min.js') }}"></script>

    <script src="{{ asset('assets/js/purchase.js') }}"></script>

    <script>
        $(document).ready(function() {
            // var v = $('#party_id').selectize({
            //     create: false,
            //     sortField: 'text'
            // });

            // v.options.addOption({value:13,text:'foo'});

            // Date and time
            $('#anytime-both').AnyTime_picker({
                format: '%d-%m-%Y %h:%i:%s %p',
            });

            //remove readonly for the input field each button datepicker clicked
            $('#anytime-both').attr("readonly", true);
            //unbind "keydown" event for the input field to make it editable
            $('#anytime-both').unbind("keydown");
            // e.preventDefault();
        });

        var app_url = '@php echo url('') @endphp';

        $("#supplier_ajax_form").on('submit', function(e){
            e.preventDefault();
            console.log($(this).attr('action'));
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function(){
                    $(document).find('span.error-text').text('');
                    $(".db_error").css("display", "none");
                    $('#db_error').text('');
                },
                success:function(data){
                    if(data.status == 0)
                    {
                        $.each(data.error,function(key, val){
                            $('span.'+key+'_error').text(val[0]);
                        });
                    }else {
                        $('#supplier_ajax_form')[0].reset();
                        if(data.message != '')
                        {
                            $(".db_error").css("display", "block");
                            $('#db_error').text(data.message);
                        }else{

                            // var newOption = new Option(data.supplier_name, data.supplier_id, false, false);

                            var option = '<option value="' + data.supplier_id + '">' + data.supplier_name + '</option>';

                            console.log(option);

                            $('#party_id').append(option);

                            console.log($('#party_id'));

                            $('#add_supplier').modal('hide');
                        }
                    }
                }
            });
        });

        function getProductPrice(item_id){
            $.ajax({
                url: app_url + '/get_item_price',
                method: 'GET',
                data: {item_id: item_id},
                dataType: 'json',
                success:function(response){
                    $("#unit_price0").val(response.data.costing_price);
                }
            });
        }
    </script>
@endpush
