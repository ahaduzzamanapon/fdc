@extends('layouts.default')

{{-- Page title --}}
@section('title')
Leaves @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    {{--<div aria-label="breadcrumb" class="card-breadcrumb">
        <h1>Leaves</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>--}}
</section>

<!-- Main content -->
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card" width="88vw;">
        <section class="card-header">
            <h5 class="card-title d-inline">ছুটির তালিকা</h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" href="{{ route('leaves.create') }}">নতুন যোগ করুন</a>
            </span>
        </section>
        <div class="card-body table-responsive">
            @include('leaves.table')
        </div>
    </div>
</div>
@endsection
