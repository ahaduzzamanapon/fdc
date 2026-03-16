@extends('layouts.default')

{{-- Page title --}}
@section('title')
{{ __('messages.party_applications') }} @parent
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
                <h5 class="card-title d-inline">{{ __('messages.party_applications') }}</h5>
                @if (Auth::guard('producer')->check() && !empty(count($filmApplications)) && $filmApplications[0]->types == 'types' && $filmApplications[0]->status == 'inactive')
                    <span class="float-right">
                        <a class="btn btn-primary pull-right" href="{{ route('partyApplications.create') }}">{{
                            __('messages.new_party_application') }}</a>
                    </span>
                @endif
            </section>
            <div class="card-body table-responsive">
                @include('party_applications.table')
            </div>
        </div>
    </div>
@endsection
