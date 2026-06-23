@extends('layouts.default')

{{-- Page title --}}
@section('title')
NOC তালিকা
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
                <h5 class="card-title d-inline">NOC আবেদন তালিকা</h5>
            </section>

            <div class="card-body table-responsive">
                <div class="table-responsive">
                    <table class="table" id="">
                        <tr>
                            <th>{{ __('messages.sl_label') }}</th>
                            <th>Registration No</th>
                            <th>Status</th>
                            <th>Name</th>
                            <th>Producer</th>
                            <th>Publish Date</th>
                            <th>Full Name</th>
                            <th>Designation</th>
                            <th>Download</th>
                        </tr>
                        @foreach ($nocs as $key => $noc)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $noc->token }}</td>
                                <td>{{ $noc->status }}</td>
                                <td>{{ $noc->name }}</td>
                                <td>{{ $noc->producer }}</td>
                                <td>{{ date('d-m-Y', strtotime($noc->publish_date)) ?? '' }}</td>
                                <td>{{ $noc->full_name }}</td>
                                <td>{{ $noc->designation }}</td>
                                <td>
                                    <a target="_blank" href="{{ route('noc.download', $noc->token) }}" class="btn btn-sm btn-success"> Download </a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
