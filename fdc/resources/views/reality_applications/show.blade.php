@extends('layouts.default')

{{-- Page title --}}
@section('title')
রিয়েলিটি শো অ্যাপ্লিকেশন @parent
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
    </div>
    <a href="{{ route('realityApplications.index') }}" class="btn btn-primary">{{ __('messages.back') }}</a>
</div>
@endsection
