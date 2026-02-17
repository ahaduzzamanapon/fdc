@extends('layouts.default')

@section('title')
Flim Report
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div aria-label="breadcrumb" class="card-breadcrumb">
        <h5><a href="{{ url('/dashboard') }}"  style="text-decoration: none; color: black;">{{ __('messages.dashboard') }}</a> > {{ __('নাটকের রিপোর্ট') }} </h5>
    </div>
    <div class="separator-breadcrumb border-top"></div>
</section>
<div class="content">
    <div class="card" width="88vw;"  height= "50vh">
        <div class="card-body table-responsive" style="height: 40vh !important">

<form id="filmReportFilter" class="row g-3 mb-4 align-items-end" action="{{ route('reports.export', ['type' => 'drama']) }}" method="POST">
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
            <option value="on process">অনিষ্পন্ন</option>
            <option value="approved">অনুমোদন</option>
            <option value="reject">বাতিল</option>
        </select>
    </div>

    <div class="col-12 d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-secondary" id="resetFilter">
            {{ __('Reset') }}
        </button>
        <button type="button" class="btn btn-primary" id="showReport">
            {{ __('Show Report') }}
        </button>

        <button type="submit" class="btn btn-success">
            Export Film Report
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
                    url: "{{ route('reports.showDramaReport') }}",
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
