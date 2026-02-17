@extends('layouts.default')

@section('title')
পার্টি অ্যাপ্লিকেশন @parent
@stop

@section('content')
<section class="content-header">
    <h1>{{ __('messages.payment_data_for_film') }} {{ $filmApplication->film_title ?? 'N/A' }}</h1>
</section>

<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card">
        <div class="card-header text-white" style="background-color: #8dc542;">
            <h4 class="card-title d-inline mb-0">{{ __('messages.payment_list') }}</h4>
            <span class="float-right">
                <a class="btn text-white" style="background-color: #8dc542; border-color: #8dc542;" href="{{ route('filmApplications.index') }}">Back to {{ __('messages.film_applications') }}</a>
            </span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="text-white" style="background-color: #8dc542;">
                        <tr>
                            <th>{{ __('messages.package_name') }}</th>
                            <th>{{ __('messages.amount') }}</th>
                            <th>{{ __('messages.transaction_id') }}</th>
                            <th>{{ __('messages.status') }}</th>
                            <th>{{ __('messages.paid_at') }}</th>
                            <th>{{ __('messages.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($filmPackage as $payment)
                        <tr>
                            <td>{{ $payment->package_name ?? 'N/A' }}</td>
                            <td>{{ $payment->amount ?? 'N/A' }}</td>
                            <td>{{ $payment->trn_id ?? 'N/A' }}</td>
                            <td><span class="badge text-white" style="background-color: #8dc542;">{{ $payment->status ?? 'N/A' }}</span></td>
                            <td>{{ $payment->updated_at ? $payment->updated_at->format('M d, Y H:i A') : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('filmApplications.single_payment_receipt', $payment->id) }}" class="btn btn-sm text-white" style="background-color: #8dc542; border-color: #8dc542;">{{ __('messages.view_receipt') }}</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">{{ __('messages.no_payment_records_found') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
