@extends('layouts.default')

@section('title')
    {{ $user->name_bn }} - ক্যারিয়ার পদোন্নতি ও ইনক্রিমেন্ট ইতিহাস টাইমলাইন
@stop

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h3><strong><i class="im im-icon-Clock me-2"></i>{{ $user->name_bn }} ({{ optional($user->designationInfo)->desi_name ?? 'কর্মকর্তা' }}) - ক্যারিয়ার টাইমলাইন</strong></h3>
                </div>
                <div class="col-sm-4 text-end">
                    <a class="btn btn-secondary" href="{{ route('employeePromotions.index') }}">
                        <i class="im im-icon-Arrow-Back"></i> তালিকায় ফিরে যান
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <!-- কর্মকর্তা প্রোফাইল সামারি কার্ড -->
        <div class="card shadow-sm border-0 mb-4 bg-light">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <img src="{{ $user->picture && $user->picture != 'no-image.png' ? asset($user->picture) : asset('picture/user/no-image.png') }}" 
                             alt="Profile Image" class="rounded-circle img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                    <div class="col-md-10">
                        <h4 class="text-primary font-weight-bold mb-1">{{ $user->name_bn }} <small class="text-muted">({{ $user->name_en }})</small></h4>
                        <div class="row text-dark mt-2">
                            <div class="col-md-3"><strong>পদবী:</strong> {{ optional($user->designationInfo)->desi_name ?? 'N/A' }}</div>
                            <div class="col-md-3"><strong>যোগদানের তারিখ:</strong> {{ $user->join_date ? \Carbon\Carbon::parse($user->join_date)->format('d/m/Y') : 'N/A' }}</div>
                            <div class="col-md-3"><strong>বর্তমান গ্রেড:</strong> {{ $user->grade ? $user->grade . 'তম গ্রেড' : 'N/A' }}</div>
                            <div class="col-md-3"><strong>বর্তমান মূল বেতন:</strong> ৳ {{ number_format($user->basic_salary, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- টাইমলাইন সেকশন -->
        <div class="card shadow-sm border-0 p-4">
            <h4 class="border-bottom pb-3 mb-4 text-secondary"><i class="im im-icon-Structure me-2"></i>যোগদান তারিখ হতে সকল ইনক্রিমেন্ট ও পদোন্নতির ইতিহাস</h4>

            <div class="timeline-container">
                <ul class="timeline-list">
                    <!-- প্রথম ইভেন্ট: যোগদান -->
                    <li class="timeline-item">
                        <div class="timeline-badge bg-info text-white"><i class="im im-icon-User"></i></div>
                        <div class="timeline-panel shadow-sm">
                            <div class="timeline-heading">
                                <span class="badge bg-info text-white float-end">প্রথম যোগদান</span>
                                <h5 class="timeline-title text-info font-weight-bold">চাকরিতে যোগদান</h5>
                                <p><small class="text-muted"><i class="im im-icon-Calendar"></i> {{ $user->join_date ? \Carbon\Carbon::parse($user->join_date)->format('d/m/Y') : 'N/A' }}</small></p>
                            </div>
                            <div class="timeline-body">
                                <p class="mb-0"><strong>প্রারম্ভিক পদবী:</strong> {{ optional($user->designationInfo)->desi_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </li>

                    @forelse($history as $item)
                        <li class="timeline-item">
                            @if($item->change_type == 'promotion')
                                <div class="timeline-badge bg-success text-white"><i class="im im-icon-Arrow-UpInCircle"></i></div>
                            @elseif($item->change_type == 'increment')
                                <div class="timeline-badge bg-primary text-white"><i class="im im-icon-Increase"></i></div>
                            @elseif($item->change_type == 'transfer')
                                <div class="timeline-badge bg-warning text-dark"><i class="im im-icon-Shuffle"></i></div>
                            @else
                                <div class="timeline-badge bg-secondary text-white"><i class="im im-icon-File"></i></div>
                            @endif

                            <div class="timeline-panel shadow-sm border-start border-4 {{ $item->change_type == 'promotion' ? 'border-success' : 'border-primary' }}">
                                <div class="timeline-heading">
                                    <span class="badge {{ $item->change_type == 'promotion' ? 'bg-success' : 'bg-primary' }} text-white float-end">
                                        {{ $item->change_type == 'promotion' ? 'পদোন্নতি' : ($item->change_type == 'increment' ? 'ইনক্রিমেন্ট' : 'বদলী/অন্যান্য') }}
                                    </span>
                                    <h5 class="timeline-title font-weight-bold {{ $item->change_type == 'promotion' ? 'text-success' : 'text-primary' }}">
                                        {{ $item->change_type == 'promotion' ? 'পদোন্নতি লাভ' : ($item->change_type == 'increment' ? 'বেতন ইনক্রিমেন্ট' : 'পদায়ন/বদলী') }}
                                    </h5>
                                    <p class="mb-2">
                                        <small class="text-muted">
                                            <i class="im im-icon-Calendar me-1"></i><strong>কার্যকরী মাস/তারিখ:</strong> {{ $item->effect_month }} 
                                            | <i class="im im-icon-Clock me-1"></i><strong>এন্ট্রি তারিখ:</strong> {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') : '' }}
                                        </small>
                                    </p>
                                </div>
                                <div class="timeline-body bg-light p-3 rounded">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>পদবী:</strong> {{ optional($item->designationInfo)->desi_name ?? 'N/A' }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>ডিপার্টমেন্ট:</strong> {{ optional($item->departmentInfo)->name_bn ?? 'N/A' }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong>শ্রেণী ও গ্রেড:</strong> {{ $item->staff_class ? $item->staff_class . 'ম শ্রেণী, ' : '' }}{{ $item->grade ? $item->grade . 'তম গ্রেড' : '' }}
                                        </div>
                                        <div class="col-md-12 mt-2">
                                            <strong>নির্ধারিত বেসিক বেতন:</strong> <span class="text-success font-weight-bold">৳ {{ number_format($item->basic_salary, 2) }}</span>
                                        </div>
                                        @if($item->remarks)
                                            <div class="col-md-12 mt-2 text-muted">
                                                <i class="im im-icon-Information me-1"></i><strong>মন্তব্য:</strong> {{ $item->remarks }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="timeline-item">
                            <div class="timeline-badge bg-secondary text-white"><i class="im im-icon-Information"></i></div>
                            <div class="timeline-panel shadow-sm">
                                <p class="mb-0 text-muted">যোগদানের পর এই কর্মকর্তা/কর্মচারীর আর কোনো অতিরিক্ত ইনক্রিমেন্ট বা পদোন্নতির রেকর্ড পাওয়া যায়নি।</p>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <style>
        .timeline-list {
            list-style: none;
            padding: 20px 0 20px;
            position: relative;
        }
        .timeline-list:before {
            top: 0;
            bottom: 0;
            position: absolute;
            content: " ";
            width: 3px;
            background-color: #e9ecef;
            left: 20px;
            margin-left: -1.5px;
        }
        .timeline-item {
            margin-bottom: 25px;
            position: relative;
        }
        .timeline-badge {
            color: #fff;
            width: 40px;
            height: 40px;
            line-height: 40px;
            font-size: 1.2em;
            text-align: center;
            position: absolute;
            top: 0;
            left: 0;
            border-radius: 50%;
            z-index: 100;
        }
        .timeline-panel {
            margin-left: 60px;
            background: #fff;
            border: 1px solid #e3e6f0;
            border-radius: 6px;
            padding: 20px;
            position: relative;
        }
    </style>
@endsection
