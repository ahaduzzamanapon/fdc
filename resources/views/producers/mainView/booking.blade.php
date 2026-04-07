@extends('layouts.default')

{{-- Page title --}}
@section('title')
প্রোডাক্ট  বুকিং  {{ __('messages.product_booking') }} @parent
@stop

@section('content')

<!-- Main content -->
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card" width="88vw;">
        <section class="card-header">
            <h5 class="card-title d-inline">{{ __('বুকিং তালিকা') }}</h5>
            @if (Auth::guard('producer')->check())
                <span class="float-right">
                    <a class="btn btn-primary pull-right" href="{{ route('producer.create_page') }}">{{ __('বুকিং করুন') }}</a>
                </span>
            @endif
        </section>

        <div class="card-body table-responsive" >
            <table class="table table-default table-hover table-striped">
                <thead>
                    <tr>
                        <th>{{ __('messages.serial') }}</th>
                        <th>{{ __('messages.booking_id') }}</th>
                        <th>{{ __('messages.status') }}</th>
                        <th> পেমেন্ট অবস্থা </th>
                        <th>{{ __('সিনেমার নাম') }} </th>
                        {{-- <th>{{ __('messages.producer') }} </th> --}}
                        <th>{{ __('messages.total_price_label') }}</th>
                        <th>{{ __('messages.date_label') }}</th>
                        <th>{{ __('messages.action_label') }}</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($booking_requests as $key => $booking)
                    @php $time = date('Y-m-d H:i:s', strtotime('-72 hours')); @endphp
                    @if($booking->pay_status == 'pending' && !empty($booking->exprired_at) &&  $booking->exprired_at < $time)
                        @php
                            $booking->status = 'expired';
                            $booking->pay_status = null;
                            $booking->exprired_at = null;
                        @endphp
                    @endif
                    <tr>
                        <td>{{  $key+1 }}</td>
                        <td>{{ $booking->book_id }}</td>
                        <td>{{ $booking->status }}</td>
                        <td>{{ $booking->pay_status }}</td>
                        <td>{{ $booking->film_title }}</td>
                        <td>{{ $booking->total_price }}</td>
                        <td>{{ date('d M Y', strtotime($booking->created_at)) }}</td>
                        <td>
                        <div class='dropdown'>
                                <button class='btn btn-outline-primary btn-xs dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                    {{ __('messages.action_label') }}
                                </button>
                                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                    <a  class='dropdown-item' href="{{ route('producer.booking_details', $booking->id) }}"><i class="im im-icon-Eye" data-placement="top" title="{{ __('messages.view_label') }}"></i> {{ __('messages.view_label') }}</a>

                                    @if ($booking->status == 'draft' && Auth::guard('producer')->check())
                                        <a href="{{ route('producer.edit.draft', [Crypt::encrypt($booking->id), 'booking']) }}" class="dropdown-item"> <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Forward to Additional Director(Sales)"></i> সম্পাদনা </a>
                                    @endif

                                    @if ($booking->status == 'approved' && Auth::guard('producer')->check())
                                        <a href="{{ route('makePayments.booking_payment', $booking->id) }}" class="dropdown-item"> <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Forward to Additional Director(Sales)"></i> পেমেন্ট করুন </a>
                                    @endif

                                    @if ($booking->status == 'on process' && !Auth::guard('producer')->check())
                                        <a href="{{ route('producerBooking.forward', [$booking->id, 'additional_director_finance']) }}" class="dropdown-item"> <i class="im im-icon-Pen" data-toggle="tooltip" data-placement="top" title="Forward to Additional Director(Sales)"></i> চেক এবং ফরোয়ার্ড </a>
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
