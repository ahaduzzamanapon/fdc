@extends('layouts.default')

{{-- Page title --}}
@section('title')
Division {{ __('messages.division') }} @parent
@stop

@section('content')
    <section class="content-header">
    {{--<div aria-label="breadcrumb" class="card-breadcrumb">
        <h1>{{ __('messages.create_new') }} {{ __('messages.division') }}</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>--}}
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    {!! Form::open(['route' => 'divisions.store','class' => 'form-horizontal col-md-12']) !!}
                    <div class="row">
                        @include('divisions.fields')
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
