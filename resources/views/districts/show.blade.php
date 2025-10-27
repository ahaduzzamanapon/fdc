@extends('layouts.default')

{{-- Page title --}}
@section('title')
Districts {{ __('messages.districts') }} @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    {{--<div aria-label="breadcrumb" class="card-breadcrumb">
        <h1>{{ __('messages.district') }}</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>--}}
</section>

<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card">
        <div class="table-responsive">
        <table class="table table-default">
            @include('districts.show_fields')

            </table>
        </div>
    </div>
    <a href="{{ route('districts.index') }}"
                class="btn btn-primary">{{ __('messages.back') }}</a>
</div>
@endsection
