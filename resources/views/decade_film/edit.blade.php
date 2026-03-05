@extends('layouts.default')

{{-- Page title --}}
@section('title')
Decade Film @parent
@stop

@section('content')
    <section class="content-header">
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    {!! Form::model($decadeFilmList, ['route' => ['decadeFilms.update', $decadeFilmList->id], 'method' => 'patch','class' => 'form-horizontal col-md-12']) !!}
                    <div class="row">
                        @include('decade_film.fields')
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
