@extends('layouts.default')

{{-- Page title --}}
@section('title')
{{ __('messages.film_applications') }} @parent
@stop

@section('content')
    <!-- Main content -->
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        @php
            use Illuminate\Support\Facades\Crypt;
        @endphp

        <div class="clearfix"></div>
        <div class="card" width="88vw;">
            <section class="card-header">
                <h5 class="card-title d-inline">{{ __('messages.film_applications') }}</h5>
                <span class="float-right">
                    <a class="btn btn-primary pull-right"
                        href="{{ route('filmApplications.create') }}">{{ __('messages.new_film_application') }}</a>
                </span>
            </section>
            <div class="card-body table-responsive">
                @include('film_applications.table')
            </div>
        </div>
    </div>
@endsection
