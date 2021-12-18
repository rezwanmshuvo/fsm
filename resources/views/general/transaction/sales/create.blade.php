@extends('layouts.app')

@push('css')
    <!-- <link rel="stylesheet" href="{{ asset('assets/plugins/selectize/dist/css/selectize.bootstrap4.css') }}"> -->
@endpush

@section('title', 'New Sale')

@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                    <span class="breadcrumb-item active">New Sale</span>
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
                <h5 class="card-title">New Sale</h5>
                <div class="header-elements">
                    <a type="button" href="{{ route('sale.index') }}" class="btn custom-btn-success"><i class="icon-circle-left2 mr-2"></i>Back</a>
                </div>
            </div>

            <div class="card-body">
                <form action="{{ route('sale.store') }}" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="customer_id" class="text-mandatory" style="display: flex; justify-content: space-between;">Customer <a href="#" data-toggle="modal" data-target="#add_customer">Add Customer</a></label>
                            <select id="customer_id" name="customer_id" class="form-control">
                                <option value="">Selelct Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ (old('customer_id') == $customer->id) ? 'selected=selected' : ''}}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                            @error('customer_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputPassword4" class="text-mandatory">sale Date</label>
                            <input type="text" name="sale_date" class="form-control  @error('sale_date') is-invalid @enderror" id="anytime-both" value="{{ old('purchase_date', date('d-m-Y g:i:s A', strtotime(now()))) }}">
                            @error('sale_date')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div style="background-color:#F5f5f5f5;" class="mb-2 p-2">
                        <div class="form-row">
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

                            <div class="form-group col-md-2">
                                <label for="item_id" class="text-mandatory">Unit Price</label>
                                <input readonly type="text" class="form-control" name="unit_price" id="unit_price0" placeholder="Unit Price" />
                            </div>
                            <div class="form-group col-md-2">
                                <label for="item_id" class="text-mandatory">Quantity</label>
                                <input type="text" class="form-control" name="quantity" id="quantity0" placeholder="Quantity" onkeyup="calc_total(0)" />
                            </div>
                            <div class="form-group col-md-2">
                                <label for="item_id" >Discount</label>
                                <input type="text" class="form-control" name="discount" id="discount0" placeholder="Discount" onkeyup="calc_total(0)" />
                            </div>

                            <div class="form-group col-md-2">
                                <label class="control-label" >Total</label>
                                <input readonly type="text" class="form-control" name="total" id="total0" />
                            </div>

                            <div class="col-md-1">
                                <div class="form-group">
                                    <label class="control-label">{{ ('Action ') }}</label>
                                    <button type="button" onclick="add_row()" class="btn btn-primary">{{  ('Add') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <table class="table table-bordered">
                            <thead>
                            <tr style="background-color:#F5f5f5f5;">
                                <th>Name</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Discount</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="output">

                            </tbody>

                            {{--                        <tr style="background-color:#F5f5f5f5;">--}}
                            {{--                            <th colspan="4" class="text-right" >Sub Total</th>--}}
                            {{--                            <th id="sub_total"></th>--}}
                            {{--                        </tr>--}}

                            <tr style="background-color:#F5f5f5f5;">
                                <th colspan="5" class="text-right" >Total Discount</th>
                                <th id="total_discount"></th>
                            </tr>

                            <tr style="background-color:#F5f5f5f5;">
                                <th colspan="5" class="text-right" >Total Sale Quantity</th>
                                <th id="total_quantity"></th>
                            </tr>

                            <tr style="background-color:#F5f5f5f5;">
                                <th colspan="5" class="text-right" >Sub Total</th>
                                <th id="grand_total"></th>
                            </tr>
                        </table>
                    </div>
                    <div class="form-group row mt-2">
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary float-right">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /form inputs -->

        <!-- add customer modal -->
        <div id="add_customer" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Customer</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-danger text-center db_error" style="display:none;" id="db_error"></div>
                        <form action="{{ route('customer.ajax-store') }}" method="POST" id="customer_ajax_form">
                            @csrf
                            <div class="form-group row">
                                <label class="col-form-label col-lg-2 text-mandatory">Customer Name</label>
                                <div class="col-lg-10">
                                    <input type="text" name="name" class="form-control" placeholder="Customer Name" value="{{ old('name') }}">
                                    <span class="text-danger error-text name_error"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2 text-mandatory">Customer Phone</label>
                                <div class="col-lg-10">
                                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Customer Phone" value="{{ old('phone') }}">
                                    <span class="text-danger error-text phone_error"></span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Customer Email</label>
                                <div class="col-lg-10">
                                    <input type="text" name="email" class="form-control" placeholder="Customer Email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label col-lg-2">Customer Address</label>
                                <div class="col-lg-10">
                                    <input type="text" name="address" class="form-control" placeholder="Customer Address" value="{{ old('address') }}">
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
    <!-- <script src="{{ asset('assets/plugins/selectize/dist/js/standalone/selectize.js') }}"></script> -->
    <script src="{{ asset('assets/global_assets/js/demo_pages/form_inputs.js') }}"></script>
    <script src="{{ asset('assets/global_assets/js/plugins/pickers/anytime.min.js') }}"></script>

    <script src="{{ asset('assets/js/sale.js') }}"></script>

    <script>
        $(document).ready(function() {
            // var v = $('#customer_id').selectize({
            //     create: false,
            //     sortField: 'text'
            // });
            //
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

        // console.log(app_url);

        $("#customer_ajax_form").on('submit', function(e){
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
                        $('#customer_ajax_form')[0].reset();
                        if(data.message != '')
                        {
                            $(".db_error").css("display", "block");
                            $('#db_error').text(data.message);
                        }else{
                            var option = '<option value="' + data.customer_id + '">' + data.customer_name + '</option>';

                            console.log(option);

                            $('#customer_id').append(option);

                            console.log($('#customer_id'));

                            $('#add_customer').modal('hide');
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
                    $("#unit_price0").val(response.data.selling_price);
                }
            });
        }

    </script>
@endpush
