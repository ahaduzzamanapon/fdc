@extends('layouts.default')
@section('title')
Profile @parent
@stop



@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div aria-label="breadcrumb" class="card-breadcrumb">
        <h5><a href="{{ url('/') }}"  style="text-decoration: none; color: black;">Dashboard</a> > Profile </h5>
    </div>
    <div class="separator-breadcrumb border-top"></div>
</section>
@section('content')
   <section class="content-header">

    </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="card">
           <div class="card-body">
                <div class="row">
                    {!! Form::model($users, ['route' => ['profile.update', $users->id], 'method' => 'patch', 'files' => true,'class' => 'form-horizontal col-md-12']) !!}
                        <div class="row">
                            @include('profile.fields')
                        </div>
                    {!! Form::close() !!}
                </div>
           </div>
       </div>
   </div>
@endsection




@endsection
