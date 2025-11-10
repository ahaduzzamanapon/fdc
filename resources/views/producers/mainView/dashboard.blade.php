@extends('layouts.default')
{{-- Page title --}}
@section('title')
    বুকিং {{ __('messages.dashboard') }} @parent
@stop
{{-- page level styles --}}
@section('header_styles')
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
@stop
@section('content')
    <section class="content-header">
        <div class="col-md-12">
            <div class="row">
                <h3 class="col-md-6 pull-left" style="padding-top : 10px">
                    বুকিং {{ __('messages.dashboard') }}
                </h3>
            </div>
        </div>
        <br>

    </section>
    <style>
        .custom-card {
            display: flex;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
            background-color: #fff;
            min-height: 89px;
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
            flex: 0 0 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 45px;
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
            flex-wrap: wrap;
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <section class="content">
        <div class="dashboard_cards_header">
            {{-- booking count --}}
            <div class="dashboard_card">
                <a class="indexLink" href="#" style="text-decoration: none!important;">
                    <div class="custom-card">
                        <div class="card-icon teal">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h3 id="total_students">
                                <div class="" role="status"> {{ en2bn($bookings->totalRow) }} </div>
                            </h3>
                            <p>{{ __('messages.total_bookings') }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="dashboard_card">
                <a class="indexLink" href="#" style="text-decoration: none!important;">
                    <div class="custom-card">
                        <div class="card-icon green">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h3 id="total_completed_movies">
                                <div class="" role="status">{{ en2bn($bookings->pendingRow) }}</div>
                            </h3>
                            <p>{{ 'অপেক্ষমান বুকিং' }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="dashboard_card">
                <a class="indexLink" href="#" style="text-decoration: none!important;">
                    <div class="custom-card">
                        <div class="card-icon blue">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h3 id="movies_awaiting_approval">
                                <div class="" role="status">{{ en2bn($bookings->approveRow) }}</div>
                            </h3>
                            <p>{{ 'অনুমোদিত বুকিং' }}</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- film count --}}
            <div class="dashboard_card">
                <a class="indexLink" href="#" style="text-decoration: none!important;">
                    <div class="custom-card">
                        <div class="card-icon red">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h3 id="commercials_awaiting_approval">
                                <div class="" role="status">{{ en2bn($films->totalRow) }}</div>
                            </h3>
                            <p>{{ 'মোট চলচ্চিত্র' }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="dashboard_card">
                <a class="indexLink" href="#" style="text-decoration: none!important;">
                    <div class="custom-card">
                        <div class="card-icon aqua">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h3 id="total_producer_list">
                                <div class="" role="status">{{ en2bn($films->pendingRow) }}</div>
                            </h3>
                            <p>{{ 'অপেক্ষমান চলচ্চিত্র' }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="dashboard_card">
                <a class="indexLink" href="#" style="text-decoration: none!important;">
                    <div class="custom-card">
                        <div class="card-icon orange">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h3 id="total_approved_producer_pending_list">
                                <div class="" role="status">{{ en2bn($films->approveRow) }}</div>
                            </h3>
                            <p>{{ 'অনুমোদিত চলচ্চিত্র' }}</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- drama count --}}
            <div class="dashboard_card">
                <a class="indexLink" href="#" style="text-decoration: none!important;">
                    <div class="custom-card">
                        <div class="card-icon teal">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h3 id="total_students">
                                <div class="" role="status"> {{ en2bn($dramas->totalRow) }} </div>
                            </h3>
                            <p>{{ 'মোট নাটক' }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="dashboard_card">
                <a class="indexLink" href="#" style="text-decoration: none!important;">
                    <div class="custom-card">
                        <div class="card-icon green">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h3 id="total_completed_movies">
                                <div class="" role="status">{{ en2bn($dramas->pendingRow) }}</div>
                            </h3>
                            <p>{{ 'অপেক্ষমান নাটক' }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="dashboard_card">
                <a class="indexLink" href="#" style="text-decoration: none!important;">
                    <div class="custom-card">
                        <div class="card-icon blue">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h3 id="movies_awaiting_approval">
                                <div class="" role="status">{{ en2bn($dramas->approveRow) }}</div>
                            </h3>
                            <p>{{ 'অনুমোদিত নাটক' }}</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- docufilm count --}}
            <div class="dashboard_card">
                <a class="indexLink" href="#" style="text-decoration: none!important;">
                    <div class="custom-card">
                        <div class="card-icon red">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h3 id="commercials_awaiting_approval">
                                <div class="" role="status">{{ en2bn($docufilms->totalRow) }}</div>
                            </h3>
                            <p>{{ 'মোট প্রামান্যচিত্র' }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="dashboard_card">
                <a class="indexLink" href="#" style="text-decoration: none!important;">
                    <div class="custom-card">
                        <div class="card-icon aqua">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h3 id="total_producer_list">
                                <div class="" role="status">{{ en2bn($docufilms->pendingRow) }}</div>
                            </h3>
                            <p>{{ 'অপেক্ষমান প্রামান্যচিত্র' }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="dashboard_card">
                <a class="indexLink" href="#" style="text-decoration: none!important;">
                    <div class="custom-card">
                        <div class="card-icon orange">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h3 id="total_approved_producer_pending_list">
                                <div class="" role="status">{{ en2bn($docufilms->approveRow) }}</div>
                            </h3>
                            <p>{{ 'অনুমোদিত প্রামান্যচিত্র' }}</p>
                        </div>
                    </div>
                </a>
            </div>

            {{-- reality show count --}}
            <div class="dashboard_card">
                <a class="indexLink" href="#" style="text-decoration: none!important;">
                    <div class="custom-card">
                        <div class="card-icon teal">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h3 id="total_students">
                                <div class="" role="status"> {{ en2bn($reality->totalRow) }} </div>
                            </h3>
                            <p>{{ 'মোট রিয়েলিটি শো' }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="dashboard_card">
                <a class="indexLink" href="#" style="text-decoration: none!important;">
                    <div class="custom-card">
                        <div class="card-icon green">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h3 id="total_completed_movies">
                                <div class="" role="status">{{ en2bn($reality->pendingRow) }}</div>
                            </h3>
                            <p>{{ 'অপেক্ষমান রিয়েলিটি শো' }}</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="dashboard_card">
                <a class="indexLink" href="#" style="text-decoration: none!important;">
                    <div class="custom-card">
                        <div class="card-icon blue">
                            <i class="icon im im-icon-User"></i>
                        </div>
                        <div class="card-content">
                            <h3 id="movies_awaiting_approval">
                                <div class="" role="status">{{ en2bn($reality->approveRow) }}</div>
                            </h3>
                            <p>{{ 'অনুমোদিত রিয়েলিটি শো' }}</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </section>
@stop
