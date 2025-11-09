@extends('layouts.default')

{{-- Page title --}}
@section('title')
নাটক অ্যাপ্লিকেশন @parent
@stop

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    {!! Form::open(['route' => 'dramaApplications.store','class' => 'form-horizontal col-md-12']) !!}
                    <div class="row">
                        @include('drama_applications.fields')
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
