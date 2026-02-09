@extends('layouts.default')

{{-- Page title --}}
@section('title')
রেজিস্ট্রেশন তালিকা @parent
@stop

@section('content')

<!-- Main content -->
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card" width="88vw;">
        <section class="card-header">
            <h5 class="card-title d-inline">রেজিস্ট্রেশন তালিকা</h5>
            <span class="float-right"> </span>
        </section>
        <div class="card-body table-responsive" >
            @include('producers.registration.table')
        </div>
    </div>

</div>
@endsection
