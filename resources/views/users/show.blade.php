@extends('layouts.default')

{{-- Page title --}}
@section('title')
Users {{ __('messages.users') }} @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    {{--<div aria-label="breadcrumb" class="card-breadcrumb">
        <h1>{{ __('messages.user') }}</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>--}}
</section>

<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card">
        <a href="{{ route('users.index') }}"
                class="btn btn-primary">{{ __('messages.back') }}</a>
        <div class="table-responsive">
        <table class="table table-default">
            @include('users.show_fields')

            </table>
        </div>
    </div>

</div>
@endsection
