@extends('layouts.default')

@section('title')
NOC Payment Report
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div aria-label="breadcrumb" class="card-breadcrumb">
        <h5><a href="{{ url('/dashboard') }}" style="text-decoration: none; color: black;">{{ __('messages.dashboard') }}</a> > {{ __('NOC পেমেন্ট রিপোর্ট') }} </h5>
    </div>
    <div class="separator-breadcrumb border-top"></div>
</section>
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card" width="88vw;">
        <div class="card-body table-responsive">
            <form id="nocReportFilter" class="row g-3 mb-4 align-items-end" action="{{ route('reports.nocPayment.export', ['type' => 'noc_payment']) }}" method="POST">
                @csrf
                <div class="col-md-3">
                    <label for="from_date" class="form-label">শুরু তারিখ</label>
                    <input type="date" id="from_date" name="from_date" class="form-control">
                </div>

                <div class="col-md-3">
                    <label for="to_date" class="form-label">শেষ তারিখ</label>
                    <input type="date" id="to_date" name="to_date" class="form-control">
                </div>

                <div class="col-md-3">
                    <label for="status" class="form-label">অবস্থা (Status)</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">সব অবস্থা</option>
                        <option value="paid" selected>পরিশোধিত (Paid)</option>
                        <option value="pending">অপেক্ষমাণ (Pending)</option>
                        <option value="approved">অনুমোদিত (Approved)</option>
                        <option value="rejected">বাতিল (Rejected)</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="search" class="form-label">অনুসন্ধান (Trx / টোকেন / চলচ্চিত্র / প্রযোজক)</label>
                    <input type="text" id="search" name="search" class="form-control" placeholder="TrxID / Token / নাম...">
                </div>

                <div class="col-12 d-flex justify-content-start gap-2 mt-3">
                    <button type="button" class="btn btn-primary" id="showNocReport">
                        <span id="showNocReportSpinner" class="spinner-border spinner-border-sm me-1" style="display: none;" role="status" aria-hidden="true"></span>
                        <span id="showNocReportText">রিপোর্ট দেখুন</span>
                    </button>
                    <button type="submit" class="btn btn-success"> এক্সেল ডাউনলোড </button>
                    <button type="button" class="btn btn-secondary" id="resetNocFilter"> রিসেট </button>
                </div>
            </form>

            <div id="nocReportResult">
                <!-- AJAX Report loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        function loadNocReport() {
            $('#showNocReportSpinner').show();
            $('#showNocReportText').text('লোড হচ্ছে...');
            $('#showNocReport').prop('disabled', true);

            $.ajax({
                url: "{{ route('reports.showNocPaymentReport') }}",
                type: "POST",
                data: $('#nocReportFilter').serialize(),
                success: function(response) {
                    $('#nocReportResult').html(response);
                },
                error: function(xhr) {
                    alert('রিপোর্ট লোড হতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
                },
                complete: function() {
                    $('#showNocReportSpinner').hide();
                    $('#showNocReportText').text('রিপোর্ট দেখুন');
                    $('#showNocReport').prop('disabled', false);
                }
            });
        }

        // Initial load
        loadNocReport();

        $('#showNocReport').on('click', function(e) {
            e.preventDefault();
            loadNocReport();
        });

        $('#resetNocFilter').on('click', function() {
            $('#nocReportFilter')[0].reset();
            loadNocReport();
        });
    });
</script>
@endsection
