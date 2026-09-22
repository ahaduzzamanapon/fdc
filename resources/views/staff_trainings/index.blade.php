@extends('layouts.default')

@section('title')
    স্টাফ প্রশিক্ষণ তালিকা @parent
@stop

@section('content')
    @include('flash::message')

    <div class="card shadow-sm border-0 mb-4" style="min-height: auto !important; flex: none !important; margin: 0px !important;">
        <!-- Header bar matching FDC theme -->
        <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center" style="background-color: #8dc542 !important; color: #ffffff !important; border-top-left-radius: 4px; border-top-right-radius: 4px;">
            <h5 class="mb-0 font-weight-bold text-white"><i class="im im-icon-Diploma me-2"></i>কর্মকর্তা ও কর্মচারীদের প্রশিক্ষণ তালিকা</h5>
            <div class="d-flex gap-2">
                @if(!who('staff'))
                    <a class="btn btn-sm font-weight-bold text-white shadow-sm" href="{{ route('staffTrainingCourses.index') }}" style="background-color: #17a2b8 !important; border: none;">
                        <i class="im im-icon-Gear me-1"></i> প্রশিক্ষণ কোর্সসমূহ
                    </a>
                @endif
                <a class="btn btn-sm font-weight-bold text-white shadow-sm" href="{{ route('employeePromotions.index') }}" style="background-color: #6c757d !important; border: none;">
                    <i class="im im-icon-Structure me-1"></i> ইনক্রিমেন্ট ও পদোন্নতি
                </a>
                <a class="btn btn-sm font-weight-bold shadow-sm" href="{{ route('staffTrainings.create') }}" style="background-color: #1f9303 !important; color: #ffffff !important; border: none;">
                    <i class="im im-icon-Add me-1"></i> নতুন ট্রেনিং যোগ করুন
                </a>
            </div>
        </div>

        <div class="card-body p-3">
            <!-- Filter Bar -->
            <form method="GET" action="{{ route('staffTrainings.index') }}" class="mb-3">
                <div class="row align-items-center g-2">
                    <div class="col-md-2">
                        <input type="text" name="start_date" class="form-control form-control-sm" placeholder="Start Date" value="{{ request('start_date') }}" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="end_date" class="form-control form-control-sm" placeholder="End Date" value="{{ request('end_date') }}" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                    </div>
                    <div class="col-md-3">
                        <select name="training_id" class="form-control form-control-sm">
                            <option value="">সকল কোর্স / বিষয়সূচী</option>
                            @foreach($courses as $id => $title)
                                <option value="{{ $id }}" {{ request('training_id') == $id ? 'selected' : '' }}>{{ $title }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if(!who('staff'))
                        <div class="col-md-3">
                            <select name="user_id" class="form-control form-control-sm">
                                <option value="">সকল কর্মকর্তা / কর্মচারী</option>
                                @foreach($users as $id => $name)
                                    <option value="{{ $id }}" {{ request('user_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div class="col-md-2 d-flex gap-1">
                        <button type="submit" class="btn btn-sm text-white flex-grow-1" style="background-color: #1f9303 !important; border-color: #1f9303 !important;">
                            ফিল্টার
                        </button>
                        <a href="{{ route('staffTrainings.index') }}" class="btn btn-outline-secondary btn-sm flex-grow-1">
                            রিসেট
                        </a>
                    </div>
                </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle mb-0" id="trainings-table">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%" class="text-center">ক্রমিক</th>
                            <th width="18%">কর্মকর্তা / কর্মচারী</th>
                            <th width="22%">প্রশিক্ষণ / কোর্স</th>
                            <th width="15%">ইনস্টিটিউট ও স্থান</th>
                            <th width="14%">মেয়াদ ও তারিখ</th>
                            <th width="12%">ফলাফল / গ্রেড</th>
                            <th width="8%" class="text-center">সনদ</th>
                            <th width="8%" class="text-center">অ্যাকশন</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trainings as $index => $item)
                            <tr>
                                <td class="text-center">{{ $trainings->firstItem() + $index }}.</td>
                                <td>
                                    <strong class="text-dark">{{ optional($item->user)->name_bn ?? optional($item->user)->name_en ?? 'N/A' }}</strong>
                                    @if(optional($item->user)->designationInfo)
                                        <br><small class="text-muted">{{ optional($item->user)->designationInfo->desi_name }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-primary">{{ $item->course_title }}</span>
                                    @if($item->course && $item->course->type)
                                        <br><span class="badge bg-info text-white px-2 py-1" style="font-size: 10px;">{{ ucfirst($item->course->type) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span>{{ $item->institute ?? 'N/A' }}</span>
                                    @if($item->location)
                                        <br><small class="text-muted"><i class="im im-icon-Location me-1"></i>{{ $item->location }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($item->start_date)
                                        <small class="d-block"><strong>শুরু:</strong> {{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }}</small>
                                    @endif
                                    @if($item->end_date)
                                        <small class="d-block"><strong>শেষ:</strong> {{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}</small>
                                    @endif
                                    @if($item->duration)
                                        <small class="badge bg-secondary text-white">{{ $item->duration }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($item->result_grade)
                                        <span class="badge bg-success text-white">{{ $item->result_grade }}</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($item->certificate_file)
                                        <a href="{{ asset($item->certificate_file) }}" target="_blank" class="btn btn-outline-primary btn-xs" title="সনদপত্র ডাউনলোড / দেখুন">
                                            <i class="im im-icon-Download"></i>
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary btn-xs dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id }}" data-bs-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            অ্যাকশন
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                            <a href="{{ route('staffTrainings.show', [$item->id]) }}" class="dropdown-item">
                                                <i class="im im-icon-Eye me-1"></i> দেখুন
                                            </a>
                                            <a href="{{ route('staffTrainings.edit', [$item->id]) }}" class="dropdown-item">
                                                <i class="im im-icon-Pen me-1"></i> সম্পাদনা
                                            </a>
                                            {!! Form::open(['route' => ['staffTrainings.destroy', $item->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                                {!! Form::button('<i class="im im-icon-Remove me-1"></i> মুছে ফেলুন', ['type' => 'submit', 'class' => 'dropdown-item text-danger', 'onclick' => "return confirm('আপনি কি নিশ্চিত?')"]) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="im im-icon-Information display-6 d-block mb-2"></i>
                                    কোনো প্রশিক্ষণ রেকর্ড পাওয়া যায়নি।
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($trainings->hasPages())
            <div class="card-footer bg-white d-flex justify-content-end py-2">
                {{ $trainings->links() }}
            </div>
        @endif
    </div>
@endsection
