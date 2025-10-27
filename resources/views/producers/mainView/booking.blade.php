@extends('layouts.default')

{{-- Page title --}}
@section('title')
প্রোডাক্ট  বুকিং  {{ __('messages.product_booking') }} @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    {{--<div aria-label="breadcrumb" class="card-breadcrumb">
        <h1>{{ __('messages.producers') }}</h1>
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
            <h5 class="card-title d-inline">{{ __('messages.product_booking') }}</h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" href="{{ route('producer.create_page') }}">{{ __('messages.book_product') }}</a>
            </span>
        </section>
        <div class="card-body table-responsive" >
            <table class="table table-default table-hover table-striped">
                <thead>
                <tr>
                    <th>{{ __('messages.serial') }}</th>
                    <th>{{ __('messages.booking_id') }}</th>
                    <th>{{ __('messages.status') }}</th>
                    <th>{{ __('messages.producer') }} </th>
                    <th>{{ __('messages.total_price_label') }}</th>
                    <th>{{ __('messages.created_at') }}</th>
                    <th>{{ __('messages.action_label') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($booking_requests as $key => $booking_request)
                <tr>
                    <td>{{  $key+1 }}</td>
                    <td>{{ $booking_request->book_id }}</td>
                    <td>{{ $booking_request->status }}</td>
                    <td>{{ $booking_request->producer_name }}</td>
                    <td>{{ $booking_request->total_price }}</td>
                    <td>{{ $booking_request->created_at }}</td>
                    <td>
                       <div class='dropdown'>
                                <button class='btn btn-outline-primary btn-xs dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                    {{ __('messages.action_label') }}
                                </button>
                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                    <a  class='dropdown-item' href="{{ route('producer.booking_details', $booking_request->id) }}"><i class="im im-icon-Eye" data-placement="top" title="{{ __('messages.view_label') }}"></i> {{ __('messages.view_label') }}</a>
                                </div>
                            </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
