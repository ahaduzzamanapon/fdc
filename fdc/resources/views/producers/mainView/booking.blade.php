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
            <h5 class="card-title d-inline">{{ __('বুকিং তালিকা') }}</h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" href="{{ route('producer.create_page') }}">{{ __('বুকিং করুন') }}</a>
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
                @foreach($booking_requests as $key => $booking)
                    <tr>
                        <td>{{  $key+1 }}</td>
                        <td>{{ $booking->book_id }}</td>
                        <td>{{ $booking->status }}</td>
                        <td>{{ $booking->producer_name }}</td>
                        <td>{{ $booking->total_price }}</td>
                        <td>{{ $booking->created_at }}</td>
                        <td>
                        <div class='dropdown'>
                                <button class='btn btn-outline-primary btn-xs dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                    {{ __('messages.action_label') }}
                                </button>
                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                    <a  class='dropdown-item' href="{{ route('producer.booking_details', $booking->id) }}"><i class="im im-icon-Eye" data-placement="top" title="{{ __('messages.view_label') }}"></i> {{ __('messages.view_label') }}</a>

                                    @if ($booking->status == 'on process' && !Auth::guard('producer')->check())
                                        <a href="{{ route('producerBooking.forward', [$booking->id, 'additional_director_finance']) }}" class="dropdown-item"> <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Forward to Additional Director(Sales)"></i>Check And Forward</a>
                                    @endif
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
