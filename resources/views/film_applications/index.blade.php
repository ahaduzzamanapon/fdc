@extends('layouts.default')

{{-- Page title --}}
@section('title')
Film Applications @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    {{--<div aria-label="breadcrumb" class="card-breadcrumb">
        <h1>Film Applications</h1>
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
            <h5 class="card-title d-inline">Film Applications</h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" href="{{ route('filmApplications.create') }}">নতুন যোগ করুন</a>
            </span>
        </section>
        <div class="card-body table-responsive" >
            @include('film_applications.table')
        </div>
    </div>
    <div class="text-center">
        
        @include('adminlte-templates::common.paginate', ['records' => $filmApplications])

    </div>
</div>
@endsection
