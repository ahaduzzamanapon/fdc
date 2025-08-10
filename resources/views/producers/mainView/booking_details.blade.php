@extends('layouts.default')

@section('title')
Booking Details @parent
@stop

@section('content')
<section class="content-header">
    <h1>Booking Details</h1>
</section>

<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card">
        <div class="card-header text-white" style="background-color: #8dc542;">
            <h4 class="card-title d-inline mb-0">Booking ID: {{ $booking->book_id }}</h4>
            <span class="float-right">
                <a class="btn btn-primary"  href="{{ route('producer.booking') }}">Back to Bookings</a>
                @if(can('booking_approve') && $booking->status == 'pending')
                    <a class="btn btn-primary "  href="{{ route('producer.approve_booking', $booking->id) }}">Approve Booking</a>
                @endif
            </span>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card mb-3" style="min-height: fit-content;">
                        <div class="card-header">Booking Information</div>
                        <div class="card-body">
                            <p><strong>Status:</strong> <span class="badge text-white" style="background-color: #8dc542;">{{ $booking->status }}</span></p>
                            <p><strong>Total Price:</strong> {{ $booking->total_price }}</p>
                            <p><strong>Created At:</strong> {{ $booking->created_at->format('M d, Y H:i A') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-3" style="min-height: fit-content;">
                        <div class="card-header">Associated Details</div>
                        <div class="card-body">
                            <p><strong>Producer:</strong> {{ $booking->producer->organization_name ?? 'N/A' }}</p>
                            <p><strong>Film:</strong> {{ $booking->film->film_title ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="mt-4 mb-3">Booked Items Details</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="text-white" style="background-color: #8dc542;">
                        <tr>
                            <th>Category</th>
                            <th>Item</th>
                            <th>Shift</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Total Days</th>
                            <th>Amount</th>
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
                            <td colspan="7" class="text-center">No booking details found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
