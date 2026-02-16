@extends('layouts.default')

{{-- Page title --}}
@section('title')
Item Departments @parent
@stop

@section('content')

<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-default">
                @include('item_departments.show_fields')
            </table>
        </div>
    </div>
    <a href="{{ route('itemDepartments.index') }}" class="btn btn-primary">Back</a>
</div>
@endsection
