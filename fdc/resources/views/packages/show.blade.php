@extends('layouts.default')

{{-- Page title --}}
@section('title')
Packages {{ __('messages.packages') }} @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    {{--<div aria-label="breadcrumb" class="card-breadcrumb">
        <h1>{{ __('messages.package') }}</h1>
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
            @include('packages.show_fields')

            </table>
        </div>
    </div>
    <a href="{{ route('packages.index') }}"
                class="btn btn-primary">{{ __('messages.back') }}</a>
</div>
@endsection
