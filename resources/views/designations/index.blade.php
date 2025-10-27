@extends('layouts.default')

{{-- Page title --}}
@section('title')
Designations {{ __('messages.designations') }} @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div aria-label="breadcrumb" class="card-breadcrumb">
        <h5><a href="{{ url('/dashboard') }}"  style="text-decoration: none; color: black;">{{ __('messages.dashboard') }}</a> > Designations </h5>
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
            <h5 class="card-title d-inline">{{ __('messages.designations') }}</h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" href="{{ route('designations.create') }}">{{ __('messages.add_new') }}</a>
            </span>
        </section>
        <div class="card-body table-responsive" >
            @include('designations.table')
        </div>
    </div>
</div>
@endsection
