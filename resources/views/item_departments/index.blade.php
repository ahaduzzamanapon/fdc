@extends('layouts.default')

{{-- Page title --}}
@section('title')
Item Departments @parent
@stop

@section('content')

<!-- Main content -->
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card" width="88vw;">
        <section class="card-header">
            <h5 class="card-title d-inline">আইটেম ডিপার্টমেন্ট</h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" href="{{ route('itemDepartments.create') }}">নতুন যোগ করুন</a>
            </span>
        </section>
        <div class="card-body table-responsive" >
            @include('item_departments.table')
        </div>
    </div>
</div>
@endsection
