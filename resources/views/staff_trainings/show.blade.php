@extends('layouts.default')

@section('title')
    প্রশিক্ষণ বিস্তারিত വിവരণ @parent
@stop

@section('content')
    @include('flash::message')

    <div class="card shadow-sm border-0 mb-4" style="min-height: auto !important; flex: none !important; margin: 0px !important;">
        <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center" style="background-color: #8dc542 !important; color: #ffffff !important; border-top-left-radius: 4px; border-top-right-radius: 4px;">
            <h5 class="mb-0 font-weight-bold text-white"><i class="im im-icon-Diploma me-2"></i>প্রশিক্ষণ বিস্তারিত বিবরণ</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('staffTrainings.edit', $training->id) }}" class="btn btn-sm btn-warning text-white font-weight-bold">
                    <i class="im im-icon-Pen me-1"></i> সম্পাদনা করুন
                </a>
                <a class="btn btn-sm font-weight-bold text-white shadow-sm" href="{{ route('staffTrainings.index') }}" style="background-color: #1f9303 !important; border: none;">
                    <i class="im im-icon-Arrow-Back me-1"></i> তালিকায় ফিরে যান
                </a>
            </div>
        </div>

        <div class="card-body p-4">
            <div class="row">
                <div class="col-md-8">
                    <table class="table table-bordered align-middle">
                        <tbody>
                            <tr>
                                <th width="30%" class="bg-light">কর্মকর্তা / কর্মচারী:</th>
                                <td>
                                    <strong class="text-primary fs-6">{{ optional($training->user)->name_bn ?? optional($training->user)->name_en }}</strong>
                                    @if(optional($training->user)->designationInfo)
                                        <br><small class="text-muted">{{ optional($training->user)->designationInfo->desi_name }}</small>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">প্রশিক্ষণ / কোর্স:</th>
                                <td>
                                    <strong class="text-dark">{{ $training->course_title }}</strong>
                                    @if($training->course && $training->course->type)
                                        <span class="badge bg-info text-white ms-2">{{ ucfirst($training->course->type) }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">ইনস্টিটিউট / প্রতিষ্ঠান:</th>
                                <td>{{ $training->institute ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">স্থান / দেশ:</th>
                                <td>{{ $training->location ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">সময়কাল / তারিখ:</th>
                                <td>
                                    @if($training->start_date)
                                        <span><strong>শুরু:</strong> {{ \Carbon\Carbon::parse($training->start_date)->format('d M Y') }}</span>
                                    @endif
                                    @if($training->end_date)
                                        <span class="ms-3"><strong>শেষ:</strong> {{ \Carbon\Carbon::parse($training->end_date)->format('d M Y') }}</span>
                                    @endif
                                    @if($training->duration)
                                        <br><span class="badge bg-secondary text-white mt-1">মেয়াদ: {{ $training->duration }}</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">ফলাফল / গ্রেড:</th>
                                <td>
                                    @if($training->result_grade)
                                        <span class="badge bg-success text-white px-2 py-1">{{ $training->result_grade }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">মন্তব্য / বিবরণ:</th>
                                <td>{{ $training->remarks ?? 'কোনো মন্তব্য প্রদান করা হয়নি।' }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">এন্ট্রি তারিখ:</th>
                                <td>{{ $training->created_at ? $training->created_at->format('d M Y, h:i A') : 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-4">
                    <div class="card border shadow-sm">
                        <div class="card-header bg-light font-weight-bold">
                            <i class="im im-icon-File-Trash me-1"></i> প্রশিক্ষণ সনদপত্র
                        </div>
                        <div class="card-body text-center p-3">
                            @if($training->certificate_file)
                                @php
                                    $ext = pathinfo($training->certificate_file, PATHINFO_EXTENSION);
                                @endphp
                                @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                                    <img src="{{ asset($training->certificate_file) }}" alt="Certificate" class="img-fluid rounded border mb-3" style="max-height: 250px;">
                                @else
                                    <div class="py-4">
                                        <i class="im im-icon-File-Text display-3 text-primary d-block mb-2"></i>
                                        <span class="text-muted small">PDF ফাইল সংযুক্ত করা আছে</span>
                                    </div>
                                @endif
                                <a href="{{ asset($training->certificate_file) }}" target="_blank" class="btn btn-primary btn-sm w-100">
                                    <i class="im im-icon-Download me-1"></i> সনদপত্র ডাউনলোড / পূর্ণরূপ দেখুন
                                </a>
                            @else
                                <div class="py-4 text-muted">
                                    <i class="im im-icon-Information display-4 d-block mb-2"></i>
                                    কোনো সনদপত্র যুক্ত করা হয়নি।
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
