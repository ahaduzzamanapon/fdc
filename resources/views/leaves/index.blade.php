@extends('layouts.default')

{{-- Page title --}}
@section('title')
Leaves @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content mb-5 mt-5" >
    <style>
        .leave-box {
            background: linear-gradient(135deg, #8dc542 0%, #f5040463 100%);
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(66, 174, 197, 0.15);
            transition: box-shadow 0.3s, transform 0.3s, background 0.3s;
        }
        .leave-box:hover {
            box-shadow: 0 8px 24px rgba(66, 174, 197, 0.25);
            background: linear-gradient(135deg, #8dc542 0%, #42aec58a 100%);
            transform: translateY(-4px) scale(1.03);
        }
    </style>
    <style>
        .custom-card {
            display: flex;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
            background-color: #fff;
            min-height: 80px;
        }

        .spinner-border {
            --bs-spinner-width: 1rem;
            --bs-spinner-height: 1rem;
            --bs-spinner-vertical-align: -0.125em;
            --bs-spinner-border-width: 0.2em;
            --bs-spinner-animation-speed: 0.50s;
            --bs-spinner-animation-name: spinner-border;
            border: var(--bs-spinner-border-width) solid currentcolor;
            border-right-color: rgba(0, 0, 0, 0);
        }

        .custom-card:hover {
            transform: translateY(-4px);
        }

        .card-icon {
            flex: 0 0 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 30px;
        }

        .card-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* <- vertical centering */
            padding: 0 15px;
        }

        .card-content h3 {
            margin: 0;
            font-size: 22px;
            color: #333;
            font-weight: bold;
        }

        .card-content p {
            margin: 4px 0 0;
            font-size: 15px;
            color: #666;
            font-weight: bold;
        }

        .teal {
            background-color: teal;
        }

        .green {
            background-color: #28a745;
        }

        .blue {
            background-color: #007bff;
        }

        .red {
            background-color: #dc3545;
        }

        .aqua {
            background-color: #17a2b8;
        }

        .fuchsia {
            background-color: #e83e8c;
        }

        .orange {
            background-color: #fd7e14;
        }

        .yellow {
            background-color: #ffc107;
        }

        .dashboard_cards_header {
            display: flex;

            /* flex-wrap: wrap; */
            align-items: center;
        }

        .dashboard_card {
            width: 30% !important;
            margin: 0px 15px !important;
        }

        .tiles-title {
            font-size: 18px !important;
        }

        .heading {
            margin-top: 8px !important;
            font-size: 18px !important;
        }

        .report-table td {
            font-size: 15px !important;
        }

        @media (max-width: 768px) {
            .dashboard_card {
                width: 100% !important;
            }
        }
    </style>
    <div class="row">

        <div class="dashboard_cards_header " >
            @foreach($total_leaves as $key => $leave)
                <div class="dashboard_card">
                    {{-- <a class="indexLink" href="#" style="text-decoration: none!important;"> --}}
                        <div class="custom-card">
                            <div class="card-icon teal">
                                <i class="icon im im-icon-User"></i>
                            </div>
                            <div class="card-content">
                                <h6 class="font-weight-bold" id="total_students">{{ $leave->name_en == 'cl' ? "ক্যাসুয়াল ছুটি" : "অসুস্থতা ছুটি" }}</h6>
                                <h6 style="font-family: SutonnyMJ">{{ 'মোট: '. $leave->day }}</h6>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach

            <div class="dashboard_card">
                    <div class="custom-card">
                        <div class="card-icon teal">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h6 style='line-height: 25px;' class="font-weight-bold">{{  "অসুস্থতা ছুটি" }}</h6>
                            <h6 style="font-family: SutonnyMJ">{{ 'ব্যবহার: ' . (isset($sl_leaves[0]) ? $sl_leaves[0]->total_days : 0)}}</h6>
                            <h6 style="font-family: SutonnyMJ">{{ 'বর্তমান ব্যালেন্স: ' . (isset($total_leaves[0]) ? ($total_leaves[0]->day - $sl_leaves[0]->total_days) : 0)}}</h6>
                        </div>
                    </div>
                </a>
            </div>
            <div class="dashboard_card">
                    <div class="custom-card">
                        <div class="card-icon teal">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h6 style='line-height: 25px;' class="font-weight-bold">{{  "ক্যাসুয়াল ছুটি" }}</h6>
                            <h6 style="font-family: SutonnyMJ">
                                {{ 'ব্যবহার: ' . ($cl_leaves[0]->total_days ?? '0') }}
                            </h6>
                            <h6 style="font-family: SutonnyMJ">
                                {{ 'বর্তমান ব্যালেন্স: ' . (isset($total_leaves[1]->day) && isset($cl_leaves[0]->total_days) ? $total_leaves[1]->day - $cl_leaves[0]->total_days : '0') }}
                            </h6>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<div class="content">
    <div class="clearfix"></div>
    {{-- @dd($total_leaves); --}}
    @include('flash::message')
    <script>
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 2000);
    </script>

    <div class="clearfix"></div>
    <div class="card" width="88vw;">
        <section class="card-header">
            <h5 class="card-title d-inline">ছুটির তালিকা</h5>
            <span class="float-right">
                <a class="btn btn-primary pull-right" href="{{ route('leaves.create') }}">নতুন যোগ করুন</a>
            </span>
        </section>
        <div class="card-body table-responsive">
            @include('leaves.table')
        </div>
    </div>
</div>
@endsection
