@extends('layouts.default')

@section('title')
    ইনক্রিমেন্ট ও পদোন্নতির তালিকা @parent
@stop

@section('content')
    @include('flash::message')

    <!-- Single main card to avoid flex stretching gaps -->
    <div class="card shadow-sm border-0 mb-4" style="min-height: auto !important; flex: none !important; margin: 0px !important;">
        <!-- Header bar with Green background matching FDC theme -->
        <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center" style="background-color: #8dc542 !important; color: #ffffff !important; border-top-left-radius: 4px; border-top-right-radius: 4px;">
            <h5 class="mb-0 font-weight-bold text-white"><i class="im im-icon-Structure me-2"></i>ইনক্রিমেন্ট ও পদোন্নতির তালিকা</h5>
            <div class="d-flex gap-2">
                @if(who('staff') || Auth::id())
                    <a class="btn btn-sm font-weight-bold text-white shadow-sm" href="{{ route('employeePromotions.timeline', Auth::id()) }}" style="background-color: #17a2b8 !important; border: none;">
                        <i class="im im-icon-Clock me-1"></i> টাইমলাইন
                    </a>
                @endif
                <a class="btn btn-sm font-weight-bold text-white shadow-sm" href="{{ route('staffTrainings.index') }}" style="background-color: #0d6efd !important; border: none;">
                    <i class="im im-icon-Diploma me-1"></i> ট্রেনিং
                </a>
                @if(!who('staff'))
                    <a class="btn btn-sm font-weight-bold shadow-sm" href="{{ route('employeePromotions.create') }}" style="background-color: #1f9303 !important; color: #ffffff !important; border: none;">
                        <i class="im im-icon-Add me-1"></i> নতুন যোগ করুন
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body p-3">
            <!-- Single Row Filter Bar - No labels, using placeholders -->
            <form method="GET" action="{{ route('employeePromotions.index') }}" class="mb-3">
                <div class="row align-items-center g-2">
                    <div class="col-md-2">
                        <input type="text" name="start_date" class="form-control form-control-sm" placeholder="Start Date" value="{{ request('start_date') }}" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="end_date" class="form-control form-control-sm" placeholder="End Date" value="{{ request('end_date') }}" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
                    </div>
                    <div class="col-md-2">
                        <select name="change_type" class="form-control form-control-sm">
                            <option value="">Status / সকল ধরণ</option>
                            <option value="promotion" {{ request('change_type') == 'promotion' ? 'selected' : '' }}>পদোন্নতি (Promotion)</option>
                            <option value="increment" {{ request('change_type') == 'increment' ? 'selected' : '' }}>ইনক্রিমেন্ট (Increment)</option>
                            <option value="joining" {{ request('change_type') == 'joining' ? 'selected' : '' }}>যোগদান (Joining)</option>
                            <option value="transfer" {{ request('change_type') == 'transfer' ? 'selected' : '' }}>বদলী/পদায়ন (Transfer)</option>
                            <option value="other" {{ request('change_type') == 'other' ? 'selected' : '' }}>অন্যান্য (Other)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="staff_class" class="form-control form-control-sm">
                            <option value="">Staff Group / সকল শ্রেণী</option>
                            <option value="1" {{ request('staff_class') == '1' ? 'selected' : '' }}>১ম শ্রেণী (Class A)</option>
                            <option value="2" {{ request('staff_class') == '2' ? 'selected' : '' }}>২য় শ্রেণী (Class B)</option>
                            <option value="3" {{ request('staff_class') == '3' ? 'selected' : '' }}>৩য় শ্রেণী (Class C)</option>
                            <option value="4" {{ request('staff_class') == '4' ? 'selected' : '' }}>৪র্থ শ্রেণী (Class D)</option>
                        </select>
                    </div>
                    @if(!who('staff'))
                        <div class="col-md-2">
                            <select name="user_id" class="form-control form-control-sm">
                                <option value="">Employee / সকল কর্মকর্তা</option>
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
                        <a href="{{ route('employeePromotions.index') }}" class="btn btn-outline-secondary btn-sm flex-grow-1">
                            রিসেট
                        </a>
                    </div>
                </div>
            </form>

            <!-- Data Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover align-middle mb-0" id="promotions-table">
                    <thead class="bg-light">
                        <tr>
                            <th width="5%" class="text-center">No.</th>
                            <th width="12%">Date</th>
                            <th width="18%">Name</th>
                            <th width="12%">Type / Status</th>
                            <th width="14%">Department</th>
                            <th width="16%">Designation</th>
                            <th width="13%">Class & Grade</th>
                            <th width="10%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($promotions as $index => $item)
                            <tr>
                                <td class="text-center">{{ $promotions->firstItem() + $index }}.</td>
                                <td>
                                    <strong>{{ $item->effect_date ? \Carbon\Carbon::parse($item->effect_date)->format('d M Y') : ($item->created_at ? $item->created_at->format('d M Y') : 'N/A') }}</strong>
                                </td>
                                <td>
                                    <strong class="text-dark">{{ optional($item->user)->name_bn ?? optional($item->user)->name_en ?? 'N/A' }}</strong>
                                    @if(optional($item->user)->mobile_no)
                                        <br>
                                        <small class="text-muted"><i class="im im-icon-Telephone"></i> {{ optional($item->user)->mobile_no }}</small>
                                    @elseif(optional($item->user)->username)
                                        <br>
                                        <small class="text-muted"><i class="im im-icon-User"></i> {{ optional($item->user)->username }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($item->change_type == 'promotion')
                                        <span class="badge bg-success text-white px-2 py-1"><i class="im im-icon-Arrow-UpInCircle"></i> পদোন্নতি</span>
                                    @elseif($item->change_type == 'increment')
                                        <span class="badge bg-info text-white px-2 py-1" style="background-color: #17a2b8 !important;"><i class="im im-icon-Increase"></i> ইনক্রিমেন্ট</span>
                                    @elseif($item->change_type == 'joining')
                                        <span class="badge bg-primary text-white px-2 py-1"><i class="im im-icon-User"></i> যোগদান</span>
                                    @elseif($item->change_type == 'transfer')
                                        <span class="badge bg-warning text-dark px-2 py-1"><i class="im im-icon-Shuffle"></i> বদলী/পদায়ন</span>
                                    @else
                                        <span class="badge bg-secondary text-white px-2 py-1">অন্যান্য</span>
                                    @endif
                                </td>
                                <td>{{ optional($item->departmentInfo)->name_bn ?? optional($item->departmentInfo)->name_en ?? 'N/A' }}</td>
                                <td>{{ optional($item->designationInfo)->desi_name ?? optional($item->designationInfo)->desi_name_en ?? 'N/A' }}</td>
                                <td>
                                    @if($item->staff_class)
                                        <span class="badge bg-light text-dark border me-1">{{ $item->staff_class }}ম শ্রেণী</span>
                                    @endif
                                    @if($item->grade)
                                        <span class="badge bg-light text-dark border">{{ $item->grade }}তম গ্রেড</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary btn-xs dropdown-toggle" type="button" id="dropdownMenuButton{{ $item->id }}" data-bs-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            অ্যাকশন
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $item->id }}">
                                            <a href="{{ route('employeePromotions.show', [$item->id]) }}" class="dropdown-item">
                                                <i class="im im-icon-Eye me-1"></i> দেখুন
                                            </a>
                                            @if(!who('staff'))
                                                <a href="{{ route('employeePromotions.edit', [$item->id]) }}" class="dropdown-item">
                                                    <i class="im im-icon-Pen me-1"></i> সম্পাদনা করুন
                                                </a>
                                                {!! Form::open(['route' => ['employeePromotions.destroy', $item->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                                    {!! Form::button('<i class="im im-icon-Remove me-1"></i> মুছে ফেলুন', ['type' => 'submit', 'class' => 'dropdown-item text-danger', 'onclick' => "return confirm('আপনি কি নিশ্চিত?')"]) !!}
                                                {!! Form::close() !!}
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="im im-icon-Information display-6 d-block mb-2"></i>
                                কোনো ইনক্রিমেন্ট বা পদোন্নতির রেকর্ড পাওয়া যায়নি।
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($promotions->hasPages())
            <div class="card-footer bg-white d-flex justify-content-end py-2">
                {{ $promotions->links() }}
            </div>
        @endif
    </div>

@endsection
