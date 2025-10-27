@extends('layouts.default')

{{-- Page title --}}
@section('title')
Designation {{ __('messages.designation') }} @parent
@stop

@section('content')
    <section class="content-header">
    {{--<div aria-label="breadcrumb" class="card-breadcrumb">
        <h1>{{ __('messages.create_new') }} {{ __('messages.designation') }}</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>--}}
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    {!! Form::open(['route' => 'designations.store','class' => 'form-horizontal col-md-12']) !!}
                    <div class="row">
                        @include('designations.fields')
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
