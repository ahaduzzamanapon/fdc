@extends('layouts.default')

@section('title')
Flim Report
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div aria-label="breadcrumb" class="card-breadcrumb">
        <h5><a href="{{ url('/dashboard') }}"  style="text-decoration: none; color: black;">{{ __('messages.dashboard') }}</a> > {{ __('রিয়েলিটি শো-এর  রিপোর্ট') }} </h5>
    </div>
    <div class="separator-breadcrumb border-top"></div>
</section>
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card" width="88vw;">

<div class="card-body table-responsive">

    <form id="filmReportFilter" class="row g-3 mb-4 align-items-end">
        <div class="col-md-2">
            <label for="from_date" class="form-label">{{ __('শুরু তারিখ') }}</label>
            <input type="date" id="from_date" name="from_date" class="form-control">
        </div>

        <div class="col-md-2">
            <label for="to_date" class="form-label">{{ __('শেষ তারিখ') }}</label>
            <input type="date" id="to_date" name="to_date" class="form-control">
        </div>

        <div class="col-md-2">
            <label for="status" class="form-label">{{ __('অবস্থা') }}</label>
            <select id="status" name="status" class="form-select">
                <option value="">{{ __('সব অবস্থা') }}</option>
                <option value="1">{{ __('অনিষ্পন্ন') }}</option>
                <option value="2">{{ __('অনুমোদন') }}</option>
                <option value="3">{{ __('বাতিল') }}</option>
            </select>
        </div>

        <div class="col-md-6">
            <label for="organization" class="form-label">{{ __('রিয়েলিটি শো-এর নাম') }}</label>
            <input type="text" id="organization" name="organization" class="form-control" placeholder="{{ __('রিয়েলিটি শো-এর নাম...') }}">
        </div>

        <div class="col-12 d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-secondary" id="resetFilter">
                <i class="bi bi-arrow-clockwise"></i> {{ __('Reset') }}
            </button>
            <button type="button" class="btn btn-primary" id="showReport">
                <i class="bi bi-search"></i> {{ __('Show Report') }}
            </button>
        </div>
    </form>
</div>

    </div>
</div>

@endsection

@section('footer_scripts')
    <script>
    $(document).ready(function () {
        $('#resetFilter').on('click', function () {
            $('#filmReportFilter')[0].reset();
        });
    });
    </script>
        <script>
        $(document).ready(function () {
            $('#showReport').on('click', function () {
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                var status = $('#status').val();
                var organization = $('#organization').val();
                $.ajax({
                    url: "{{ route('reports.showRealityReport') }}",
                    method: "POST",
                    type: "POST",
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        status: status,
                        organization: organization,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        var width = screen.availWidth;
                        var height = screen.availHeight;
                        // Open popup with full width and height
                        var newWindow = window.open(
                            '',
                            '_blank',
                            `width=${width},height=${height},top=0,left=0,scrollbars=yes,resizable=yes`
                        );
                        newWindow.document.write(response);
                        newWindow.document.close();
                    }
                });
            });
        });
    </script>
@endsection
