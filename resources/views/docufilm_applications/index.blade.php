@extends('layouts.default')

{{-- Page title --}}
@section('title')
প্রামান্যচিত্র অ্যাপ্লিকেশন @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<!-- Main content -->
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card" width="88vw;">
        <section class="card-header">
            <h5 class="card-title d-inline">প্রামান্যচিত্র অ্যাপ্লিকেশন</h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" href="{{ route('docufilmApplications.create') }}">{{ __('messages.add_new') }}</a>
            </span>
        </section>
        <div class="card-body table-responsive" >
            @include('docufilm_applications.table')
        </div>
    </div>
</div>
@endsection
