@extends('layouts.default')

@section('title')
Booking Details {{ __('messages.booking_details') }} @parent
@stop

@section('content')
<section class="content-header">
    <h1>{{ __('messages.booking_details') }}</h1>
</section>

<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card">
        <div class="card-header text-white" style="background-color: #8dc542;">
            <h4 class="card-title d-inline mb-0">Booking ID: {{ $booking->book_id }}</h4>
            <span class="float-right">
                <a class="btn btn-primary"  href="{{ route('producer.booking') }}">{{ __('messages.back_to_bookings') }}</a>
                @if(can('booking_approve') && $booking->status == 'pending')
                    <a class="btn btn-primary "  href="{{ route('producer.approve_booking', $booking->id) }}">{{ __('messages.approve_booking') }}</a>
                @endif
            </span>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card mb-3" style="min-height: fit-content;">
                        <div class="card-header">{{ __('messages.booking_information') }}</div>
                        <div class="card-body">
                            <p><strong>{{ __('messages.status_label') }}</strong> <span class="badge text-white" style="background-color: #8dc542;">{{ $booking->status }}</span></p>
                            <p><strong>{{ __('messages.total_price') }}</strong> {{ $booking->total_price }}</p>
                            <p><strong>{{ __('messages.created_at') }}:</strong> {{ $booking->created_at->format('M d, Y H:i A') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3" style="min-height: fit-content;">
                        <div class="card-header">{{ __('messages.associated_details') }}</div>
                        <div class="card-body">
                            <p><strong>{{ __('messages.producer') }}:</strong> {{ $booking->producer->organization_name ?? 'N/A' }}</p>
                            <p><strong>{{ __('messages.film_label') }}</strong> {{ $booking->film->film_title ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="mt-4 mb-3">{{ __('messages.booked_items_details') }}</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="text-white" style="background-color: #8dc542;">
                        <tr>
                            <th>{{ __('messages.category') }}</th>
                            <th>{{ __('messages.item') }}</th>
                            <th>{{ __('messages.shift') }}</th>
                            <th>{{ __('messages.start_date') }}</th>
                            <th>{{ __('messages.end_date') }}</th>
                            <th>{{ __('messages.total_days') }}</th>
                            <th>{{ __('messages.amount') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($booking->details as $detail)
                        <tr>
                            <td>{{ $detail->catagori }}</td>
                            <td>{{ $detail->item->name_bn ?? 'N/A' }}</td>
                            <td>{{ $detail->shift->name ?? 'N/A' }}</td>
                            <td>{{ $detail->start_date }}</td>
                            <td>{{ $detail->end_date }}</td>
                            <td>{{ $detail->total_day }}</td>
                            <td>{{ $detail->total_amount }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">{{ __('messages.no_booking_details_found') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
