@extends('layouts.default')

{{-- Page title --}}
@section('title')
Decade Film Details @parent
@stop

@section('content')
<section class="content-header">
    <h1>{{ __('messages.view') }} {{ __('messages.film_name') }}</h1>
</section>
<div class="content">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <tr>
                            <th>{{ __('messages.film_name') }}</th>
                            <td>{{ $decadeFilmList->film_name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.producer_name') }}</th>
                            <td>{{ $decadeFilmList->producer_name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.director_name') }}</th>
                            <td>{{ $decadeFilmList->director_name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.acting') }}</th>
                            <td>{{ $decadeFilmList->acting }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.type') }}</th>
                            <td>{{ $decadeFilmList->type }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.release_date') }}</th>
                            <td>{{ $decadeFilmList->release_date }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.achievements') }}</th>
                            <td>{{ $decadeFilmList->achivements }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.created_at') }}</th>
                            <td>{{ $decadeFilmList->created_at }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('messages.updated_at') }}</th>
                            <td>{{ $decadeFilmList->updated_at }}</td>
                        </tr>
                    </table>
                    <a href="{{ route('decadeFilms.index') }}" class="btn btn-secondary">{{ __('messages.back') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
