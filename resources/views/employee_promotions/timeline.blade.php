@extends('layouts.default')

@section('title')
    {{ $user->name_bn }} - ক্যারিয়ার টাইমলাইন @parent
@stop

@section('content')
    <div class="card shadow-sm border-0 mb-4" style="min-height: auto !important; flex: none !important; margin: 0px !important;">
        <!-- Header bar with Green background matching FDC theme -->
        <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center" style="background-color: #8dc542 !important; color: #ffffff !important; border-top-left-radius: 4px; border-top-right-radius: 4px;">
            <h5 class="mb-0 font-weight-bold text-white"><i class="im im-icon-Clock me-2"></i>{{ $user->name_bn }} - ক্যারিয়ার পদোন্নতি ও ইনক্রিমেন্ট টাইমলাইন</h5>
            <a class="btn btn-sm font-weight-bold shadow-sm" href="{{ route('employeePromotions.index') }}" style="background-color: #1f9303 !important; color: #ffffff !important; border: none;">
                <i class="im im-icon-Arrow-Back me-1"></i> তালিকায় ফিরে যান
            </a>
        </div>

        <div class="card-body p-4">
            <!-- কর্মকর্তা / কর্মচারীর সংক্ষিপ্ত সারসংক্ষেপ -->
            <div class="row mb-4">
                <div class="col-md-2 text-center mb-3 mb-md-0">
                    <img src="{{ $user->picture && $user->picture != 'no-image.png' ? asset($user->picture) : asset('picture/user/no-image.png') }}" 
                         alt="Profile Image" class="rounded-circle img-thumbnail shadow-sm" style="width: 110px; height: 110px; object-fit: cover;">
                </div>
                <div class="col-md-10">
                    <h4 class="text-primary font-weight-bold mb-2">{{ $user->name_bn }} <small class="text-muted">({{ $user->name_en }})</small></h4>
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tr class="bg-light">
                                <th width="20%">পদবী:</th>
                                <td>{{ optional($user->designationInfo)->desi_name ?? 'N/A' }}</td>
                                <th width="20%">যোগদানের তারিখ:</th>
                                <td>{{ $user->join_date ? \Carbon\Carbon::parse($user->join_date)->format('d/m/Y') : 'N/A' }}</td>
                            </tr>
                            <tr class="bg-light">
                                <th>বর্তমান গ্রেড:</th>
                                <td>{{ $user->grade ? $user->grade . 'তম গ্রেড' : 'N/A' }}</td>
                                <th>বর্তমান মূল বেতন:</th>
                                <td><strong class="text-success">৳ {{ number_format($user->basic_salary, 2) }}</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <h5 class="font-weight-bold mb-4 text-dark"><i class="im im-icon-Structure me-2 text-success"></i>যোগদান তারিখ হতে সকল ইনক্রিমেন্ট ও পদোন্নতির ইতিহাস</h5>

            <!-- টাইমলাইন লিস্ট -->
            <div class="timeline-container px-2">
                <ul class="timeline-list">
                    <!-- প্রথম ইভেন্ট: যোগদান -->
                    <li class="timeline-item mb-4">
                        <div class="timeline-badge bg-info text-white"><i class="im im-icon-User"></i></div>
                        <div class="timeline-panel shadow-sm border p-3 rounded">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="timeline-title text-info font-weight-bold mb-0">চাকরিতে প্রারম্ভিক যোগদান</h6>
                                <span class="badge bg-info text-white">প্রথম যোগদান</span>
                            </div>
                            <p class="text-muted mb-2" style="font-size: 13px;">
                                <i class="im im-icon-Calendar me-1"></i><strong>তারিখ:</strong> {{ $user->join_date ? \Carbon\Carbon::parse($user->join_date)->format('d/m/Y') : 'N/A' }}
                            </p>
                            <div class="p-2 bg-light rounded">
                                <strong>প্রারম্ভিক পদবী:</strong> {{ optional($user->designationInfo)->desi_name ?? 'N/A' }}
                            </div>
                        </div>
                    </li>

                    @forelse($history as $item)
                        <li class="timeline-item mb-4">
                            @if($item->change_type == 'promotion')
                                <div class="timeline-badge bg-success text-white"><i class="im im-icon-Arrow-UpInCircle"></i></div>
                            @elseif($item->change_type == 'increment')
                                <div class="timeline-badge bg-primary text-white"><i class="im im-icon-Increase"></i></div>
                            @elseif($item->change_type == 'transfer')
                                <div class="timeline-badge bg-warning text-dark"><i class="im im-icon-Shuffle"></i></div>
                            @else
                                <div class="timeline-badge bg-secondary text-white"><i class="im im-icon-File"></i></div>
                            @endif

                            <div class="timeline-panel shadow-sm border border-start border-4 {{ $item->change_type == 'promotion' ? 'border-success' : 'border-primary' }} p-3 rounded">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="timeline-title font-weight-bold mb-0 {{ $item->change_type == 'promotion' ? 'text-success' : 'text-primary' }}">
                                        {{ $item->change_type == 'promotion' ? 'পদোন্নতি লাভ' : ($item->change_type == 'increment' ? 'বেতন ইনক্রিমেন্ট' : 'পদায়ন/বদলী') }}
                                    </h6>
                                    <span class="badge {{ $item->change_type == 'promotion' ? 'bg-success' : 'bg-primary' }} text-white">
                                        {{ $item->change_type == 'promotion' ? 'পদোন্নতি' : ($item->change_type == 'increment' ? 'ইনক্রিমেন্ট' : 'বদলী/অন্যান্য') }}
                                    </span>
                                </div>
                                <p class="text-muted mb-2" style="font-size: 13px;">
                                    <i class="im im-icon-Calendar me-1"></i><strong>কার্যকরী মাস/তারিখ:</strong> {{ $item->effect_month }} 
                                    | <i class="im im-icon-Clock me-1"></i><strong>এন্ট্রি তারিখ:</strong> {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') : 'N/A' }}
                                </p>
                                <div class="p-3 bg-light rounded">
                                    <div class="row g-2">
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
                            <div class="timeline-panel shadow-sm border p-3 rounded">
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
            padding: 10px 0;
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
