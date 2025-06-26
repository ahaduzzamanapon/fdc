@extends('layouts.default')

{{-- Page title --}}
@section('title')
Districts @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div aria-label="breadcrumb" class="card-breadcrumb">
        <h5><a href="{{ url('/') }}"  style="text-decoration: none; color: black;">Dashboard</a> > Districts </h5>
    </div>
    <div class="separator-breadcrumb border-top"></div>
</section>


<!-- Main content -->
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card" width="88vw;">
        <section class="card-header">
            <h5 class="card-title d-inline">Districts</h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" href="{{ route('districts.create') }}">Add New</a>
            </span>
        </section>
        <div class="card-body table-responsive" >
            @include('districts.table')
        </div>
    </div>
</div>
@endsection
