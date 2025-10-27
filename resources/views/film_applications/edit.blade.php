@extends('layouts.default')

{{-- Page title --}}
@section('title')
Film Application {{ __('messages.film_application') }} @parent
@stop

@section('content')
   <section class="content-header">
    {{--<div aria-label="breadcrumb" class="card-breadcrumb">
        <h1>{{ __('messages.edit') }} {{ __('messages.film_application') }}</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>--}}
    </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="card">
           <div class="card-body">
                <div class="row">
                    {!! Form::model($filmApplication, ['route' => ['filmApplications.update', $filmApplication->id], 'method' => 'patch','class' => 'form-horizontal col-md-12']) !!}
                        <div class="row">
                            @include('film_applications.fields')
                        </div>
                    {!! Form::close() !!}
                </div>
           </div>
       </div>
   </div>
@endsection
