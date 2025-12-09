@extends('layouts.default')

{{-- Page title --}}
@section('title')
রিয়েলিটি শো অ্যাপ্লিকেশন @parent
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
            <h5 class="card-title d-inline">রিয়েলিটি শো অ্যাপ্লিকেশন</h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" href="{{ route('realityApplications.create') }}">{{ 'নতুন রিয়েলিটি শো আবেদন।' }}</a>
            </span>
        </section>
        <div class="card-body table-responsive" >
            @include('reality_applications.table')
        </div>
    </div>
</div>
@endsection
