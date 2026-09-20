@extends('layouts.default')

@section('title')
Payment Report
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div aria-label="breadcrumb" class="card-breadcrumb">
        <h5><a href="{{ url('/dashboard') }}"  style="text-decoration: none; color: black;">{{ __('messages.dashboard') }}</a> > {{ __('পেমেন্ট রিপোর্ট') }} </h5>
    </div>
    <div class="separator-breadcrumb border-top"></div>
</section>
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card" width="88vw;">
        <div class="card-body table-responsive">
            <form id="filmReportFilter" class="row g-3 mb-4 align-items-end" action="{{ route('reports.payment.export', ['type' => 'payment']) }}" method="POST">
            @csrf
            
                <div class="col-md-2">
                    <label for="from_date" class="form-label">শুরু তারিখ</label>
                    <input type="date" id="from_date" name="from_date" class="form-control">
                </div>

                <div class="col-md-2">
                    <label for="to_date" class="form-label">শেষ তারিখ</label>
                    <input type="date" id="to_date" name="to_date" class="form-control">
                </div>

                <div class="col-md-2">
                    <label for="status" class="form-label">অবস্থা</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">সব অবস্থা</option>
                        <option value="success">পরিশোধিত</option>
                        <option value="refound">রিফাউন্ড</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="film_type" class="form-label">সেবা নির্বাচন</label>
                    <select id="film_type" name="film_type" class="form-select">
                        <option value="">সেবা নির্বাচন করুন</option>
                        <option value="film">সিনেমা</option>
                        <option value="drama">নাটক</option>
                        <option value="docufilm">প্রামাণ্যচিত্র</option>
                        <option value="reality">রিয়েলিটি শো</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label id="film_id_label" for="film_id" class="form-label">আবেদনকৃত সেবা</label>
                    <select id="film_id" name="film_id" class="form-select">
                        <option value="">সব আবেদন</option>
                    </select>
                </div>

                <div class="col-12 d-flex justify-content-start gap-2 mt-3">
                    <button type="button" class="btn btn-primary" id="showReport">
                        <span id="showReportSpinner" class="spinner-border spinner-border-sm me-1" style="display: none;" role="status" aria-hidden="true"></span>
                        <span id="showReportText">রিপোর্ট দেখুন</span>
                    </button>
                    <button type="submit" class="btn btn-success"> এক্সেল ডাউনলোড </button>
                    <button type="button" class="btn btn-secondary" id="resetFilter"> রিসেট </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('footer_scripts')
    <script>
    $(document).ready(function () {
        $('#film_type').on('change', function () {
            var film_type = $(this).val();
            $('#film_id').html('<option value="">লোড হচ্ছে...</option>');
            if (film_type) {
                $.ajax({
                    url: "{{ route('reports.getApplicationsByType') }}",
                    type: "GET",
                    data: { film_type: film_type },
                    success: function (data) {
                        var html = '<option value="">সব আবেদন</option>';
                        $.each(data, function (key, value) {
                            html += '<option value="' + value.id + '">' + (value.film_title || value.name || 'আবেদন #' + value.id) + '</option>';
                        });
                        $('#film_id').html(html);
                    },
                    error: function () {
                        $('#film_id').html('<option value="">সব আবেদন</option>');
                    }
                });
            } else {
                $('#film_id').html('<option value="">সব আবেদন</option>');
            }
        });

        $('#resetFilter').on('click', function () {
            $('#filmReportFilter')[0].reset();
            $('#film_id').html('<option value="">সব আবেদন</option>');
        });

        $('#showReport').on('click', function () {
            var $btn = $(this);
            var $spinner = $('#showReportSpinner');
            var $btnText = $('#showReportText');

            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var status = $('#status').val();
            var film_type = $('#film_type').val();
            var film_id = $('#film_id').val();

            // 1. Open popup window immediately synchronously (prevents popup blocker)
            var width = screen.availWidth;
            var height = screen.availHeight;
            var newWindow = window.open(
                '',
                '_blank',
                `width=${width},height=${height},top=0,left=0,scrollbars=yes,resizable=yes`
            );

            if (newWindow) {
                newWindow.document.write(`
                    <!DOCTYPE html>
                    <html lang="bn">
                    <head>
                        <meta charset="UTF-8">
                        <title>রিপোর্ট লোড হচ্ছে...</title>
                        <style>
                            body { display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; }
                            .loader-box { text-align: center; padding: 40px; background: white; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
                            .spinner { border: 4px solid #e9ecef; border-top: 4px solid #8dc542; border-radius: 50%; width: 45px; height: 45px; animation: spin 0.8s linear infinite; margin: 0 auto 18px; }
                            @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
                            h4 { color: #2c3e50; margin: 0 0 8px 0; font-size: 20px; }
                            p { color: #6c757d; margin: 0; font-size: 14px; }
                        </style>
                    </head>
                    <body>
                        <div class="loader-box">
                            <div class="spinner"></div>
                            <h4>রিপোর্ট লোড হচ্ছে...</h4>
                            <p>অনুগ্রহ করে কিছুক্ষণ অপেক্ষা করুন</p>
                        </div>
                    </body>
                    </html>
                `);
            }

            // 2. Show spinner on button and disable button
            $btn.prop('disabled', true);
            $spinner.show();
            $btnText.text('লোড হচ্ছে...');

            $.ajax({
                url: "{{ route('reports.showPaymentReport') }}",
                method: "POST",
                type: "POST",
                data: {
                    from_date: from_date,
                    to_date: to_date,
                    status: status,
                    film_type: film_type,
                    film_id: film_id,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    if (newWindow) {
                        newWindow.document.open();
                        newWindow.document.write(response);
                        newWindow.document.close();
                    }
                },
                error: function () {
                    if (newWindow) {
                        newWindow.close();
                    }
                    alert('রিপোর্ট লোড করতে সমস্যা হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।');
                },
                complete: function () {
                    $btn.prop('disabled', false);
                    $spinner.hide();
                    $btnText.text('রিপোর্ট দেখুন');
                }
            });
        });
    });
    </script>
@endsection
