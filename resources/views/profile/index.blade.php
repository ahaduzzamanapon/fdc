@extends('layouts.default')
@section('title')
Profile {{ __('messages.profile') }} @parent
@stop
@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
        <div aria-label="breadcrumb" class="card-breadcrumb">
            <h5><a href="{{ url('/dashboard') }}" style="text-decoration: none; color: black;">{{ __('messages.dashboard') }}</a> &gt; {{ __('messages.profile') }} </h5>
        </div>
        <div class="separator-breadcrumb border-top"></div>
    </section>
    <div class="clearfix"></div>
    @include('flash::message')
    <script>
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 2000);
    </script>

    @php
        $userPic = asset('assets/images/avatars/01.png');
        if (Auth::user() && Auth::user()->picture && Auth::user()->picture !== 'no-image.png') {
            $picPath = \Illuminate\Support\Str::startsWith(Auth::user()->picture, 'picture/user/')
                ? Auth::user()->picture
                : 'picture/user/' . Auth::user()->picture;
            if (file_exists(public_path($picPath))) {
                $userPic = asset($picPath);
            }
        }

        $permParts = array_filter([
            Auth::user()->village,
            optional(Auth::user()->upazila)->name_bn ?? optional(Auth::user()->upazila)->name,
            optional(Auth::user()->district)->name_bn ?? optional(Auth::user()->district)->name_en,
            optional(Auth::user()->division)->name_bn ?? optional(Auth::user()->division)->name_en,
        ]);
        $permanentAddress = implode(', ', $permParts) ?: '-';

        $presParts = array_filter([
            Auth::user()->present_village,
            optional(Auth::user()->presentUpazila)->name_bn ?? optional(Auth::user()->presentUpazila)->name,
            optional(Auth::user()->presentDistrict)->name_bn ?? optional(Auth::user()->presentDistrict)->name_en,
            optional(Auth::user()->presentDivision)->name_bn ?? optional(Auth::user()->presentDivision)->name_en,
        ]);
        $presentAddress = implode(', ', $presParts) ?: '-';
    @endphp

    <style>
        .profile-table th {
            width: 22%;
            background-color: #f8f9fa;
            vertical-align: middle !important;
            padding: 12px 16px !important;
            font-weight: 600;
            color: #333;
        }
        .profile-table td {
            width: 28%;
            vertical-align: middle !important;
            padding: 12px 22px !important;
            color: #2c3e50;
        }
        .profile-table td.full-width {
            width: 78%;
        }
    </style>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center" style="padding: 12px 20px;">
                            <h4 class="card-title mb-0 text-white font-weight-bold" style="font-size: 18px;">
                                <i class="fas fa-user-circle mr-2"></i> {{ __('messages.user_profile') }}
                            </h4>
                            <a href="{{ route('profile.edit', Auth::id()) }}" class="btn btn-light btn-sm font-weight-bold shadow-sm" style="color: #001BFE;">
                                <i class="fas fa-edit mr-1"></i> {{ __('messages.edit_profile') }}
                            </a>
                        </div>
                        <div class="card-body p-4">
                            <div class="row align-items-start">
                                <!-- Profile Image & Basic Info Section -->
                                <div class="col-lg-3 col-md-4 text-center mb-4 mb-md-0 border-right pb-3">
                                    <div class="position-relative d-inline-block mb-3">
                                        <img src="{{ $userPic }}"
                                            alt="User Image"
                                            class="rounded-circle img-thumbnail shadow-sm"
                                            style="width: 140px; height: 140px; object-fit: cover; border: 3px solid #001BFE;">
                                    </div>
                                    <h4 class="font-weight-bold text-dark mb-1" style="font-size: 18px;">{{ Auth::user()->name_bn }}</h4>
                                    @if(Auth::user()->name_en)
                                        <p class="text-muted mb-2" style="font-size: 14px;">{{ Auth::user()->name_en }}</p>
                                    @endif

                                    <div class="my-2">
                                        <span class="badge badge-primary px-3 py-2 shadow-sm d-inline-block" style="font-size: 14px; background-color: #001BFE; letter-spacing: 0.5px;">
                                            <i class="fas fa-id-card mr-1"></i> আইডি: <strong>{{ Auth::user()->username }}</strong>
                                        </span>
                                    </div>

                                    <p class="text-secondary mb-1 mt-2" style="font-size: 13px;">
                                        <i class="fas fa-envelope mr-1 text-primary"></i> {{ Auth::user()->email ?? '-' }}
                                    </p>
                                    @if(optional(Auth::user()->role)->name)
                                        <span class="badge badge-info px-2 py-1 mt-1 font-weight-normal" style="font-size: 12px;">
                                            {{ optional(Auth::user()->role)->name }}
                                        </span>
                                    @endif

                                    <div class="mt-4 d-none d-md-block">
                                        <a href="{{ route('profile.edit', Auth::id()) }}" class="btn btn-outline-primary btn-block btn-sm shadow-sm">
                                            <i class="fas fa-edit mr-1"></i> {{ __('messages.edit_profile') }}
                                        </a>
                                    </div>
                                </div>

                                <!-- Profile Details Table Section -->
                                <div class="col-lg-9 col-md-8 pl-md-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover profile-table mb-0" style="table-layout: fixed; width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <th><i class="fas fa-id-badge mr-1 text-primary"></i> {{ __('messages.username') }} :</th>
                                                    <td class="font-weight-bold text-primary">{{ Auth::user()->username }}</td>
                                                    <th><i class="fas fa-phone-alt mr-1 text-primary"></i> {{ __('messages.phone') }} :</th>
                                                    <td>{{ Auth::user()->mobile_no ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-calendar-alt mr-1 text-primary"></i> {{ __('messages.joining_date') }} :</th>
                                                    <td>{{ Auth::user()->join_date ?? (Auth::user()->created_at ? Auth::user()->created_at->format('d M, Y') : '-') }}</td>
                                                    <th><i class="fas fa-briefcase mr-1 text-primary"></i> {{ __('messages.designation') }} :</th>
                                                    <td>{{ optional(Auth::user()->designationInfo)->desi_name ?? Auth::user()->designation ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-building mr-1 text-primary"></i> {{ __('বিভাগ ও শাখা') }} :</th>
                                                    <td>{{ optional(Auth::user()->departmentInfo)->name_bn ?? Auth::user()->department ?? '-' }}</td>
                                                    <th><i class="fas fa-user-tag mr-1 text-primary"></i> {{ __('messages.user_role') }} :</th>
                                                    <td>{{ optional(Auth::user()->role)->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-user mr-1 text-primary"></i> {{ __('messages.father_name') }} :</th>
                                                    <td>{{ Auth::user()->father_name ?? '-' }}</td>
                                                    <th><i class="fas fa-user mr-1 text-primary"></i> {{ __('messages.mother_name') }} :</th>
                                                    <td>{{ Auth::user()->mother_name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-id-card mr-1 text-primary"></i> {{ __('messages.nid') }} :</th>
                                                    <td>{{ Auth::user()->nid ?? '-' }}</td>
                                                    <th><i class="fas fa-birthday-cake mr-1 text-primary"></i> {{ __('messages.date_of_birth') }} :</th>
                                                    <td>{{ Auth::user()->dob ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-pray mr-1 text-primary"></i> {{ __('messages.religion') }} :</th>
                                                    <td>{{ Auth::user()->religion ?? '-' }}</td>
                                                    <th><i class="fas fa-tint mr-1 text-primary"></i> {{ __('messages.blood_group') }} :</th>
                                                    <td>{{ Auth::user()->blood_group ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-graduation-cap mr-1 text-primary"></i> {{ __('messages.educational_qualification') }} :</th>
                                                    <td>{{ Auth::user()->highest_qualification ?? '-' }}</td>
                                                    <th><i class="fas fa-medal mr-1 text-primary"></i> {{ __('মুক্তিযোদ্ধা') }} :</th>
                                                    <td>{{ Auth::user()->freedom_fighter ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-ring mr-1 text-primary"></i> {{ __('messages.marital_status') }} :</th>
                                                    <td>{{ Auth::user()->marital_status ?? '-' }}</td>
                                                    <th><i class="fas fa-child mr-1 text-primary"></i> {{ __('messages.number_of_children') }} :</th>
                                                    <td>{{ Auth::user()->no_of_child ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-home mr-1 text-primary"></i> {{ __('messages.permanent_address') }} :</th>
                                                    <td colspan="3" class="full-width">{{ $permanentAddress }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-map-marker-alt mr-1 text-primary"></i> {{ __('messages.present_address') }} :</th>
                                                    <td colspan="3" class="full-width">{{ $presentAddress }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
