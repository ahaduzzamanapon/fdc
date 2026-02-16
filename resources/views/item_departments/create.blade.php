@extends('layouts.default')

{{-- Page title --}}
@section('title')
Item Unit {{ __('messages.item_unit') }} @parent
@stop

@section('content')

    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    {!! Form::open(['route' => 'itemDepartments.store','class' => 'form-horizontal col-md-12']) !!}
                    <div class="row">
                        @include('item_departments.fields')
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
