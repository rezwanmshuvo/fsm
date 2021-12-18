@extends('layouts.app')

@section('title', 'Permissions')

@section('content')
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
        <div class="d-flex">
            <div class="breadcrumb">
                <a href="{{ route('dashboard') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dahboard</a>
                <span class="breadcrumb-item active">Permissions</span>
            </div>
        </div>
    </div>
</div>
<!-- /page header -->


<!-- Content area -->
<div class="content">
    <div class="card" style="min-height:550px!important;">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">All Permissions</h5>
            <div class="header-elements">
                <a type="button" href="{{ route('permission.create') }}" class="btn custom-btn-success"><i class="icon-plus3 mr-2"></i>Add Permission</a>
            </div>
        </div>

        <div class="row p-2">
            @if($pages->isEmpty())
                <div class="col-8 offset-2">
                    <div class="text-center">
                        <div class="alert alert-danger border-0 alert-dismissible">
                            <span class="font-weight-semibold">Oh snap!</span> No permission found. Please  <a href="{{ route('permission.create') }}" class="alert-link">try creating</a> new permission.
                        </div>
                    </div>
                </div>
            @endif
            @foreach($pages as $page)
            <div class="col-lg-4">
                <div class="card card-body custom-border-top" style="min-height:266px!important;">
                    <div class="text-center">
                        <h4 class="mb-0 font-weight-bold">{{ ucfirst($page->title) }}</h4>
                    </div>
                    <div class="card card-body bg-light mb-0">
                        @if($page->title == 'global')
                            <ul class="list list-unstyled mb-0">
                                <li><i class="icon-checkmark2 mr-2"></i> {{ $page->title }}</li>
                            </ul>
                        @else
                            <ul class="list list-unstyled mb-0">
                                <li><i class="icon-checkmark2 mr-2"></i> {{ $page->title }} view</li>
                                <li><i class="icon-checkmark2 mr-2"></i> {{ $page->title }} create</li>
                                <li><i class="icon-checkmark2 mr-2"></i> {{ $page->title }} edit</li>
                                <li><i class="icon-checkmark2 mr-2"></i> {{ $page->title }} delete</li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
<!-- /content area -->
@endsection
