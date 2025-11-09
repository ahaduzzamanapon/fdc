@extends('layouts.default')

@section('title')
Flim Report
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div aria-label="breadcrumb" class="card-breadcrumb">
        <h5><a href="{{ url('/dashboard') }}"  style="text-decoration: none; color: black;">{{ __('messages.dashboard') }}</a> > {{ __('Reality Report') }} </h5>
    </div>
    <div class="separator-breadcrumb border-top"></div>
</section>
<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    <div class="clearfix"></div>
    <div class="card" width="88vw;">

<div class="card-body table-responsive">

    <!-- 🔎 Filter Section -->
    <form id="filmReportFilter" class="row g-3 mb-4 align-items-end">
        <div class="col-md-2">
            <label for="from_date" class="form-label">{{ __('From Date') }}</label>
            <input type="date" id="from_date" name="from_date" class="form-control">
        </div>

        <div class="col-md-2">
            <label for="to_date" class="form-label">{{ __('To Date') }}</label>
            <input type="date" id="to_date" name="to_date" class="form-control">
        </div>

        <div class="col-md-2">
            <label for="status" class="form-label">{{ __('Status') }}</label>
            <select id="status" name="status" class="form-select">
                <option value="">{{ __('All Status') }}</option>
                <option value="pending">{{ __('Pending') }}</option>
                <option value="approved">{{ __('Approved') }}</option>
                <option value="rejected">{{ __('Rejected') }}</option>
            </select>
        </div>

        <div class="col-md-6">
            <label for="organization" class="form-label">{{ __('Organization Name') }}</label>
            <input type="text" id="organization" name="organization" class="form-control" placeholder="{{ __('Search Organization') }}">
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

    <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>SL</th>
                <th>Film Title</th>
                <th>Applicant Name</th>
                <th>Organization Name</th>
                <th>Status</th>
                <th>Desk</th>
            </tr>
        </thead>
        <tbody id="reportTableBody">
            <!-- Dynamic rows will be inserted here -->
            <tr>
                <td colspan="6" class="text-muted">Please select filters and click <strong>"Show Report"</strong>.</td>
            </tr>
        </tbody>
    </table>

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
@endsection
