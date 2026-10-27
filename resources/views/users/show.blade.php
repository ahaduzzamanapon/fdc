@extends('layouts.default')

{{-- Page title --}}
@section('title')
    {{ $users->name_bn ?? $users->name_en ?? 'User' }} - {{ __('messages.user_profile') }} @parent
@stop

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div aria-label="breadcrumb" class="card-breadcrumb">
        <h5>
            <a href="{{ url('/dashboard') }}" style="text-decoration: none; color: black;">{{ __('messages.dashboard') }}</a> &gt; 
            <a href="{{ route('users.index') }}" style="text-decoration: none; color: black;">{{ __('messages.users') }}</a> &gt; 
            {{ $users->name_bn ?? $users->name_en ?? __('messages.user_profile') }}
        </h5>
    </div>
    <div class="separator-breadcrumb border-top"></div>
</section>

<div class="content">
    <div class="clearfix"></div>

    @include('flash::message')

    @php
        $userPic = asset('assets/images/avatars/01.png');
        if ($users->picture && $users->picture !== 'no-image.png') {
            $picPath = \Illuminate\Support\Str::startsWith($users->picture, 'picture/user/')
                ? $users->picture
                : 'picture/user/' . $users->picture;
            if (file_exists(public_path($picPath))) {
                $userPic = asset($picPath);
            } elseif (file_exists(public_path($users->picture))) {
                $userPic = asset($users->picture);
            }
        }

        $showSig = '';
        if ($users->signature && $users->signature !== 'no-image.png') {
            $sigPath = \Illuminate\Support\Str::startsWith($users->signature, 'images/signature/') 
                ? $users->signature 
                : 'images/signature/' . $users->signature;
            if (file_exists(public_path($sigPath))) {
                $showSig = asset($sigPath);
            } elseif (file_exists(public_path($users->signature))) {
                $showSig = asset($users->signature);
            }
        }

        $permParts = array_filter([
            $users->village,
            optional($users->upazila)->name_bn ?? optional($users->upazila)->name,
            optional($users->district)->name_bn ?? optional($users->district)->name_en,
            optional($users->division)->name_bn ?? optional($users->division)->name_en,
        ]);
        $permanentAddress = implode(', ', $permParts) ?: '-';

        $presParts = array_filter([
            $users->present_village,
            optional($users->presentUpazila)->name_bn ?? optional($users->presentUpazila)->name,
            optional($users->presentDistrict)->name_bn ?? optional($users->presentDistrict)->name_en,
            optional($users->presentDivision)->name_bn ?? optional($users->presentDivision)->name_en,
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
                                <i class="fas fa-user-circle mr-2 me-2"></i> {{ __('messages.user_profile') }}
                            </h4>
                            <div class="d-flex align-items-center">
                                <a href="{{ route('employeePromotions.timeline', $users->id) }}" class="btn btn-info btn-sm font-weight-bold text-white shadow-sm mr-2 me-2" style="background-color: #17a2b8; border: none;">
                                    <i class="im im-icon-Clock mr-1 me-1"></i> টাইমলাইন
                                </a>
                                <a href="{{ route('users.edit', $users->id) }}" class="btn btn-light btn-sm font-weight-bold shadow-sm mr-2 me-2" style="color: #001BFE;">
                                    <i class="fas fa-edit mr-1 me-1"></i> {{ __('messages.edit') }}
                                </a>
                                <a href="{{ route('users.index') }}" class="btn btn-outline-light btn-sm font-weight-bold shadow-sm">
                                    <i class="fas fa-arrow-left mr-1 me-1"></i> {{ __('messages.back') }}
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="row align-items-start">
                                <!-- Profile Image & Basic Info Section -->
                                <div class="col-lg-3 col-md-4 text-center mb-4 mb-md-0 border-right pb-3">
                                    <div class="position-relative d-inline-block mb-3">
                                        <img src="{{ $userPic }}"
                                            alt="{{ $users->name_bn }}"
                                            class="rounded-circle img-thumbnail shadow-sm"
                                            style="width: 140px; height: 140px; object-fit: cover; border: 3px solid #001BFE;">
                                    </div>
                                    <h4 class="font-weight-bold text-dark mb-1" style="font-size: 18px;">{{ $users->name_bn }}</h4>
                                    @if($users->name_en)
                                        <p class="text-muted mb-2" style="font-size: 14px;">{{ $users->name_en }}</p>
                                    @endif

                                    <div class="my-2">
                                        <span class="badge badge-primary px-3 py-2 shadow-sm d-inline-block" style="font-size: 14px; background-color: #001BFE; letter-spacing: 0.5px;">
                                            <i class="fas fa-id-card mr-1 me-1"></i> আইডি: <strong>{{ $users->username }}</strong>
                                        </span>
                                    </div>

                                    <p class="text-secondary mb-1 mt-2" style="font-size: 13px;">
                                        <i class="fas fa-envelope mr-1 me-1 text-primary"></i> {{ $users->email ?? '-' }}
                                    </p>
                                    @if(optional($users->role)->name)
                                        <span class="badge badge-info px-2 py-1 mt-1 font-weight-normal" style="font-size: 12px;">
                                            {{ optional($users->role)->name }}
                                        </span>
                                    @endif

                                    @if($showSig)
                                        <div class="mt-3 p-2 bg-light rounded border text-center">
                                            <small class="text-muted d-block mb-1 font-weight-bold">স্বাক্ষর</small>
                                            <img src="{{ $showSig }}" style="max-height: 45px; max-width: 140px; object-fit: contain;" alt="Signature">
                                        </div>
                                    @endif

                                    <div class="mt-4 d-none d-md-block">
                                        <a href="{{ route('employeePromotions.timeline', $users->id) }}" class="btn btn-outline-info btn-block btn-sm shadow-sm mb-2 font-weight-bold w-100">
                                            <i class="im im-icon-Clock mr-1 me-1"></i> টাইমলাইন
                                        </a>
                                        <a href="{{ route('users.edit', $users->id) }}" class="btn btn-outline-primary btn-block btn-sm shadow-sm mb-2 w-100">
                                            <i class="fas fa-edit mr-1 me-1"></i> {{ __('messages.edit') }}
                                        </a>
                                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-block btn-sm shadow-sm w-100">
                                            <i class="fas fa-arrow-left mr-1 me-1"></i> {{ __('messages.back') }}
                                        </a>
                                    </div>
                                </div>

                                <!-- Profile Details Table Section -->
                                <div class="col-lg-9 col-md-8 pl-md-4 ps-md-4">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover profile-table mb-0" style="table-layout: fixed; width: 100%;">
                                            <tbody>
                                                <tr>
                                                    <th><i class="fas fa-id-badge mr-1 me-1 text-primary"></i> {{ __('messages.username') }} :</th>
                                                    <td class="font-weight-bold text-primary">{{ $users->username }}</td>
                                                    <th><i class="fas fa-phone-alt mr-1 me-1 text-primary"></i> {{ __('messages.phone') }} :</th>
                                                    <td>{{ $users->mobile_no ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-calendar-alt mr-1 me-1 text-primary"></i> {{ __('messages.joining_date') }} :</th>
                                                    <td>{{ $users->join_date ?? ($users->created_at ? $users->created_at->format('d M, Y') : '-') }}</td>
                                                    <th><i class="fas fa-briefcase mr-1 me-1 text-primary"></i> {{ __('messages.designation') }} :</th>
                                                    <td>{{ optional($users->designationInfo)->desi_name ?? $users->designation ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-building mr-1 me-1 text-primary"></i> {{ __('বিভাগ ও শাখা') }} :</th>
                                                    <td>{{ optional($users->departmentInfo)->name_bn ?? $users->department ?? '-' }}</td>
                                                    <th><i class="fas fa-user-tag mr-1 me-1 text-primary"></i> {{ __('messages.user_role') }} :</th>
                                                    <td>{{ optional($users->role)->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-user mr-1 me-1 text-primary"></i> {{ __('messages.father_name') }} :</th>
                                                    <td>{{ $users->father_name ?? '-' }}</td>
                                                    <th><i class="fas fa-user mr-1 me-1 text-primary"></i> {{ __('messages.mother_name') }} :</th>
                                                    <td>{{ $users->mother_name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-id-card mr-1 me-1 text-primary"></i> {{ __('messages.nid') }} :</th>
                                                    <td>{{ $users->nid ?? '-' }}</td>
                                                    <th><i class="fas fa-birthday-cake mr-1 me-1 text-primary"></i> {{ __('messages.date_of_birth') }} :</th>
                                                    <td>{{ $users->dob ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-pray mr-1 me-1 text-primary"></i> {{ __('messages.religion') }} :</th>
                                                    <td>{{ $users->religion ?? '-' }}</td>
                                                    <th><i class="fas fa-tint mr-1 me-1 text-primary"></i> {{ __('messages.blood_group') }} :</th>
                                                    <td>{{ $users->blood_group ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-venus-mars mr-1 me-1 text-primary"></i> {{ __('messages.gender') }} :</th>
                                                    <td>{{ $users->gender ?? '-' }}</td>
                                                    <th><i class="fas fa-ring mr-1 me-1 text-primary"></i> {{ __('messages.marital_status') }} :</th>
                                                    <td>{{ $users->marital_status ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-graduation-cap mr-1 me-1 text-primary"></i> {{ __('messages.educational_qualification') }} :</th>
                                                    <td>{{ $users->highest_qualification ?? '-' }}</td>
                                                    <th><i class="fas fa-medal mr-1 me-1 text-primary"></i> {{ __('মুক্তিযোদ্ধা') }} :</th>
                                                    <td>{{ $users->freedom_fighter ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-layer-group mr-1 me-1 text-primary"></i> {{ __('messages.officer_class') }} :</th>
                                                    <td>
                                                        @php
                                                            $classes = [
                                                                '1' => __('messages.class_a'),
                                                                '2' => __('messages.class_b'),
                                                                '3' => __('messages.class_c'),
                                                                '4' => __('messages.class_d'),
                                                            ];
                                                        @endphp
                                                        {{ $classes[$users->staff_class] ?? ($users->staff_class ? $users->staff_class . 'ম শ্রেণী' : '-') }}
                                                    </td>
                                                    <th><i class="fas fa-award mr-1 me-1 text-primary"></i> {{ __('messages.grade') }} :</th>
                                                    <td>{{ $users->grade ? $users->grade . 'তম গ্রেড' : '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-money-bill-wave mr-1 me-1 text-primary"></i> {{ __('messages.basic_salary') }} :</th>
                                                    <td><strong class="text-success">{{ $users->basic_salary ? '৳ ' . number_format($users->basic_salary, 2) : '-' }}</strong></td>
                                                    <th><i class="fas fa-toggle-on mr-1 me-1 text-primary"></i> {{ __('messages.current_status') }} :</th>
                                                    <td>
                                                        @if($users->current_status == 'Active')
                                                            <span class="badge badge-success">{{ __('messages.active') }}</span>
                                                        @else
                                                            <span class="badge badge-danger">{{ __('messages.inactive') }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-home mr-1 me-1 text-primary"></i> {{ __('messages.permanent_address') }} :</th>
                                                    <td colspan="3" class="full-width">{{ $permanentAddress }}</td>
                                                </tr>
                                                <tr>
                                                    <th><i class="fas fa-map-marker-alt mr-1 me-1 text-primary"></i> {{ __('messages.present_address') }} :</th>
                                                    <td colspan="3" class="full-width">{{ $presentAddress }}</td>
                                                </tr>
                                                @if($users->note)
                                                <tr>
                                                    <th><i class="fas fa-sticky-note mr-1 me-1 text-primary"></i> {{ __('messages.note') ?? 'মন্তব্য' }} :</th>
                                                    <td colspan="3" class="full-width">{{ $users->note }}</td>
                                                </tr>
                                                @endif
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
</div>
@endsection
