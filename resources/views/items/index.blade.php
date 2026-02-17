@extends('layouts.default')

{{-- Page title --}}
@section('title')
Items @parent
@stop

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        {{--<div aria-label="breadcrumb" class="card-breadcrumb">
            <h1>Items</h1>
        </div>
        <div class="separator-breadcrumb border-top"></div>--}}
    </section>

    <!-- Main content -->
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="card" width="88vw;">
            <section class="card-header">
                <h5 class="card-title d-inline">Items</h5>
                <span class="float-right">
                    <a class="btn btn-primary pull-right" href="{{ route('items.create') }}">নতুন যোগ করুন</a>
                    <a class="btn btn-success pull-right" href="{{ route('items.export') }}"
                        style="margin-right: 5px;">Export</a>
                    <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#importModal"
                        style="margin-right: 5px;">Import</button>
                </span>
            </section>
            <div class="card-body table-responsive">
                @include('items.table')
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Items</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('items.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="file">Select Excel File</label>
                            <input type="file" name="file" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection