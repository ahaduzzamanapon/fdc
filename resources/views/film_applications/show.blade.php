@extends('layouts.default')

{{-- Page title --}}
@section('title')
{{ __('messages.film_applications') }} @parent
@stop

@section('content')

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card">
            <div class="table-responsive">
                <table class="table table-default">
                    @include('film_applications.show_fields')
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('filmApplications.index') }}" class="btn btn-primary">{{ __('messages.back') }}</a>
            </div>
        </div>
    </div>
@endsection
