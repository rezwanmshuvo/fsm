@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.bootstrap4.min.css">
@endpush

@section('title', 'Banks')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dasboard</a>
                <span class="breadcrumb-item active">Banks</span>
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
            <h5 class="card-title">Banks</h5>
            <div class="header-elements">
                <a type="button" href="{{ route('bank.create') }}" class="btn custom-btn-success"><i class="icon-plus3 mr-2"></i>Add Bank</a>
            </div>
        </div>

        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
    <!-- /form inputs -->

</div>
<!-- /content area -->
@endsection

@push('js')
    <!-- Theme JS files -->

    <script src="{{ asset('assets/global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/global_assets/js/demo_pages/datatables_basic.js') }}"></script> --}}
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
    {{$dataTable->scripts()}}
    <script>
        function confirmDelete(id)
        {
            if(confirm("Are you sure you want to delete the selected bank?"))
            {
                document.getElementById('delete-form'+id).submit();
            }
        }
    </script>
@endpush
