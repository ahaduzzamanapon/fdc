@extends('layouts.default')

{{-- Page title --}}
@section('title')
ছুটি প্রকার @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    {{--<div aria-label="breadcrumb" class="card-breadcrumb">
        <h1>ছুটি প্রকার</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>--}}
</section>

<!-- Main content -->
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')
    <script>
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 2000);
    </script>

    <div class="clearfix"></div>
    <div class="card" width="88vw;">
        <section class="card-header">
            <h5 class="card-title d-inline">ছুটি প্রকার</h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" href="{{ route('leaveTypes.create') }}">নতুন যোগ করুন</a>
            </span>
        </section>
        <div class="card-body table-responsive" >
            @include('leave_types.table')
        </div>
    </div>
</div>
@endsection
