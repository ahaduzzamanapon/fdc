@extends('layouts.default')

@section('title')
Add Photo @parent
@stop

@section('content')
<section class="content-header"></section>
<div class="content">
    @include('adminlte-templates::common.errors')
    <div class="card">
        <div class="card-body">
            <div class="row">
                {!! Form::open(['route' => 'decadeFilmsPhotos.store','files' => true,'class' => 'form-horizontal col-md-12']) !!}
                    <div class="row">
                        @include('decade_films_photos.fields')
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
