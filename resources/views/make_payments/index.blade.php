@extends('layouts.default')

{{-- Page title --}}
@section('title')
নাটক অ্যাপ্লিকেশন @parent
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
            <h5 class="card-title d-inline">পেমেন্ট তালিকা </h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" onclick="makePaymentModal()" >{{ __('messages.add_new') }}</a>
            </span>
        </section>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="text-white" style="background-color: #8dc542;">
                        <tr>
                            <th>{{ 'নং' }}</th>
                            <th>{{ 'নাম' }}</th>
                            <th>{{ __('messages.amount') }}</th>
                            <th>{{ 'লেনদেন আইডি' }}</th>
                            <th>{{ 'অবস্থা' }}</th>
                            <th>{{ 'তারিখ' }}</th>
                            <th>{{ 'কার্যক্রম' }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($filmPackage as $key => $payment)
                        <tr>
                            <td>{{ ++$key ?? 'N/A' }}</td>
                            <td>{{ $payment->name ?? 'N/A' }}</td>
                            <td>{{ $payment->amount ?? 'N/A' }}</td>
                            <td>{{ $payment->trn_id ?? 'N/A' }}</td>
                            <td><span class="badge text-white" style="background-color: #8dc542;">{{ $payment->status ?? 'N/A' }}</span></td>
                            <td>{{ $payment->updated_at ? $payment->updated_at->format('M d, Y H:i A') : 'N/A' }}</td>
                            <td>
                                <a target="_blank" href="{{ route('filmApplications.single_payment_receipt', $payment->id) }}" class="btn btn-sm text-white" style="background-color: #8dc542; border-color: #8dc542;">{{ 'পেমেন্ট স্লিপ' }}</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">{{ 'কোনও পেমেন্ট রেকর্ড পাওয়া যায়নি' }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="makePaymentCitizen" tabindex="-1" role="dialog" aria-labelledby="makePaymentModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="makePaymentModalTitle">{{ __('messages.select_package') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    onclick="$('#makePayment').modal('hide')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-md-12" style="display: flex;flex-wrap: wrap;gap: 47px;">
                    @php
                        $packages = \App\Models\Package::all();
                    @endphp

                    @foreach ($packages as $package)
                    <!-- From Uiverse.io by Bodyhc -->
                    <div class="checkbox-wrapper-16">
                        <label class="checkbox-wrapper">
                            <input class="checkbox-input" type="radio" name="package_id" value="{{ $package->id }}">
                            <span class="checkbox-tile">
                                <span class="checkbox-icon">
                                    <svg viewBox="0 0 256 256" fill="currentColor" height="192" width="192"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect fill="none" height="256" width="256"></rect>
                                        <polygon stroke-width="12" stroke-linejoin="round" stroke-linecap="round"
                                            stroke="currentColor" fill="none"
                                            points="72 40 184 40 240 104 128 224 16 104 72 40"></polygon>
                                        <polygon stroke-width="12" stroke-linejoin="round" stroke-linecap="round"
                                            stroke="currentColor" fill="none"
                                            points="177.091 104 128 224 78.909 104 128 40 177.091 104"></polygon>
                                        <line stroke-width="12" stroke-linejoin="round" stroke-linecap="round"
                                            stroke="currentColor" fill="none" y2="104" x2="240" y1="104" x1="16"></line>
                                    </svg>
                                </span>
                                <span class="checkbox-label">{{ $package->name }}</span>
                            </span>
                        </label>
                    </div>
                    @endforeach

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="$('#makePayment').modal('hide')"
                    data-dismiss="modal">{{ __('messages.close') }}</button>
                <button type="button" class="btn btn-primary" onclick="submitPayment()">{{ __('messages.save_changes') }}</button>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
    <script>
        function makePaymentModal() {
            $('#makePaymentCitizen').modal('show');
        }
        function submitPayment() {
            const checkedPackageId = $('input[name="package_id"]:checked').val();
            window.location.href = `{{ route('makePayments.make_payment', [':package_id']) }}`.replace(':package_id', checkedPackageId);
        }
    </script>
@endsection
