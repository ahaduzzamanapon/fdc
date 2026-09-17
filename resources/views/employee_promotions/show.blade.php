@extends('layouts.default')

@section('title')
    ইনক্রিমেন্ট ও পদোন্নতির বিবরণ
@stop

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3><strong>ইনক্রিমেন্ট / পদোন্নতির বিবরণী</strong></h3>
                </div>
                <div class="col-sm-6 text-end">
                    @if($promotion->user_id)
                        <a class="btn btn-info text-white me-2" href="{{ route('employeePromotions.timeline', $promotion->user_id) }}">
                            <i class="im im-icon-Clock"></i> সম্পূর্ণ ক্যারিয়ার টাইমলাইন
                        </a>
                    @endif
                    <a class="btn btn-secondary" href="{{ route('employeePromotions.index') }}">
                        <i class="im im-icon-Arrow-Back"></i> তালিকায় ফিরে যান
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 border-end">
                        <h4 class="text-primary font-weight-bold mb-3"><i class="im im-icon-User"></i> কর্মকর্তা / কর্মচারীর তথ্য</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th width="35%">নাম (বাংলা)</th>
                                <td>{{ optional($promotion->user)->name_bn ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>নাম (ইংরেজি)</th>
                                <td>{{ optional($promotion->user)->name_en ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>মোবাইল নম্বর</th>
                                <td>{{ optional($promotion->user)->mobile_no ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>ইমেইল</th>
                                <td>{{ optional($promotion->user)->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>যোগদানের তারিখ</th>
                                <td>{{ optional($promotion->user)->join_date ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h4 class="text-success font-weight-bold mb-3"><i class="im im-icon-Structure"></i> পদোন্নতি / ইনক্রিমেন্ট বিবরণ</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th width="35%">পরিবর্তনের ধরণ</th>
                                <td>
                                    @if($promotion->change_type == 'promotion')
                                        <span class="badge bg-success text-white px-2 py-1">পদোন্নতি (Promotion)</span>
                                    @elseif($promotion->change_type == 'increment')
                                        <span class="badge bg-primary text-white px-2 py-1">ইনক্রিমেন্ট (Increment)</span>
                                    @elseif($promotion->change_type == 'joining')
                                        <span class="badge bg-info text-white px-2 py-1">যোগদান (Joining)</span>
                                    @elseif($promotion->change_type == 'transfer')
                                        <span class="badge bg-warning text-dark px-2 py-1">বদলী/পদায়ন</span>
                                    @else
                                        <span class="badge bg-secondary text-white px-2 py-1">অন্যান্য</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>কার্যকরী মাস / তারিখ</th>
                                <td><strong>{{ $promotion->effect_month }}</strong></td>
                            </tr>
                            <tr>
                                <th>ডিপার্টমেন্ট</th>
                                <td>{{ optional($promotion->departmentInfo)->name_bn ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>পদবী</th>
                                <td>{{ optional($promotion->designationInfo)->desi_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>অফিসার শ্রেণী</th>
                                <td>{{ $promotion->staff_class ? $promotion->staff_class . 'ম শ্রেণী' : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>গ্রেড</th>
                                <td>{{ $promotion->grade ? $promotion->grade . 'তম গ্রেড' : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>বেসিক বেতন</th>
                                <td><strong class="text-primary font-size-18">৳ {{ number_format($promotion->basic_salary, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <th>রেকর্ড তৈরির তারিখ</th>
                                <td>{{ $promotion->created_at ? \Carbon\Carbon::parse($promotion->created_at)->format('d/m/Y h:i A') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>এন্ট্রি করেছেন</th>
                                <td>{{ optional($promotion->creator)->name_bn ?? optional($promotion->creator)->name_en ?? 'Admin' }}</td>
                            </tr>
                        </table>
                    </div>

                    @if($promotion->remarks)
                    <div class="col-md-12 mt-3">
                        <div class="alert alert-info border-0">
                            <strong><i class="im im-icon-Information me-1"></i> বিবরণ / মন্তব্য:</strong>
                            <p class="mb-0 mt-1">{{ $promotion->remarks }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="card-footer bg-light text-end">
                <a href="{{ route('employeePromotions.edit', $promotion->id) }}" class="btn btn-warning text-white">
                    <i class="im im-icon-Edit"></i> সম্পাদনা করুন
                </a>
            </div>
        </div>
    </div>
@endsection
