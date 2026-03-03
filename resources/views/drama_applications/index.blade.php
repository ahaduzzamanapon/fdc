@extends('layouts.default')

{{-- Page title --}}
@section('title')
{{ __('messages.drama_applications') }} @parent
@stop

@section('content')
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card" width="88vw;">
            <section class="card-header">
                <h5 class="card-title d-inline">{{ __('messages.drama_applications') }}</h5>
                <span class="float-right">
                    <a class="btn btn-primary pull-right"
                        href="{{ route('dramaApplications.create') }}">{{ __('messages.new_drama_application') }}</a>
                </span>
            </section>
            <div class="card-body table-responsive">
                @include('drama_applications.table')
            </div>
        </div>
    </div>
@endsection