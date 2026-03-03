@extends('layouts.default')

{{-- Page title --}}
@section('title')
{{ __('messages.reality_applications') }} @parent
@stop

@section('content')
    <!-- Content Header (Page header) -->

    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card">
            <div class="table-responsive">
                <table class="table table-default">
                    @include('reality_applications.show_fields')
                </table>
            </div>
            <div class="card-footer">
                <a href="{{ route('realityApplications.index') }}" class="btn btn-primary">{{ __('messages.back') }}</a>
            </div>
        </div>
    </div>
@endsection