@extends('layouts.default')

{{-- Page title --}}
@section('title')
User {{ __('messages.user') }} @parent
@stop

@section('content')

   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="card">
           <div class="card-body">
                <div class="row">
                    {!! Form::model($users, ['route' => ['invPermissions.update', $users->id], 'method' => 'patch', 'files' => true,'class' => 'form-horizontal col-md-12']) !!}
                        <div class="row">
                            @include('invPermissions.fields')
                        </div>
                    {!! Form::close() !!}
                </div>
           </div>
       </div>
   </div>
@endsection
