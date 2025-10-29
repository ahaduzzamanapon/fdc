@extends('layouts.default')

{{-- Page title --}}
@section('title')
Approval Flow Steps @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    {{--<div aria-label="breadcrumb" class="card-breadcrumb">
        <h1>Approval Flow Steps</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>--}}
</section>

<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-default">
                @include('approval_flow_steps.show_fields')
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('approvalFlowSteps.index') }}" class="btn btn-primary">Back</a>
        </div>
    </div>
</div>
@endsection
