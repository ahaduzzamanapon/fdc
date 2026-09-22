@extends('layouts.default')

@section('title')
    প্রশিক্ষণ কোর্স ও বিষয়সূচী ব্যবস্থাপনা @parent
@stop

@section('content')
    @include('flash::message')

    <div class="row g-1" style="margin: 0px !important;">
        <!-- Add / Edit Course Form -->
        <div class="col-md-4 mb-3 ps-0 pe-1">
            <div class="card shadow-sm border-0" style="margin: 0px !important;">
                <div class="card-header py-2 px-3 text-white" style="background-color: #8dc542 !important;">
                    <h5 class="mb-0 font-weight-bold"><i class="im im-icon-Add me-2"></i>নতুন কোর্স যোগ করুন</h5>
                </div>
                <div class="card-body p-3">
                    {!! Form::open(['route' => 'staffTrainingCourses.store', 'method' => 'post']) !!}
                        <div class="mb-3">
                            {!! Form::label('title', 'কোর্সের শিরোনাম / নাম:', ['class' => 'form-label font-weight-bold']) !!} <span class="text-danger">*</span>
                            {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'যেমন: বুনিয়াদী প্রশিক্ষণ']) !!}
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            {!! Form::label('type', 'কোর্সের ধরণ:', ['class' => 'form-label font-weight-bold']) !!} <span class="text-danger">*</span>
                            {!! Form::select('type', [
                                'local' => 'স্বদেশী (Local)',
                                'foreign' => 'বৈদেশিক (Foreign)',
                                'internal' => 'অভ্যন্তরীণ (Internal)',
                                'external' => 'বহিরাগত (External)',
                                'online' => 'অনলাইন (Online)',
                                'workshop' => 'কর্মশালা / ওয়ার্কশপ'
                            ], 'local', ['class' => 'form-control']) !!}
                        </div>

                        <div class="mb-3">
                            {!! Form::label('description', 'সংক্ষিপ্ত বিবরণ:', ['class' => 'form-label font-weight-bold']) !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'কোর্স সম্পর্কিত বিবরণ...']) !!}
                        </div>

                        <div class="mb-3 form-check">
                            {!! Form::checkbox('status', '1', true, ['class' => 'form-check-input', 'id' => 'status']) !!}
                            {!! Form::label('status', 'সক্রিয় (Active)', ['class' => 'form-check-label']) !!}
                        </div>

                        <button type="submit" class="btn text-white font-weight-bold w-100" style="background-color: #1f9303 !important;">
                            সংরক্ষণ করুন
                        </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <!-- Course List Table -->
        <div class="col-md-8 mb-3 ps-1 pe-0">
            <div class="card shadow-sm border-0" style="margin: 0px !important;">
                <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center text-white" style="background-color: #8dc542 !important;">
                    <h5 class="mb-0 font-weight-bold"><i class="im im-icon-Gear me-2"></i>প্রশিক্ষণ কোর্সসমূহ</h5>
                    <a class="btn btn-sm font-weight-bold text-white shadow-sm" href="{{ route('staffTrainings.index') }}" style="background-color: #1f9303 !important; border: none;">
                        <i class="im im-icon-Arrow-Back me-1"></i> প্রশিক্ষণ তালিকায় ফিরে যান
                    </a>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th width="8%" class="text-center">ক্রমিক</th>
                                    <th width="35%">কোর্সের নাম</th>
                                    <th width="20%">ধরণ</th>
                                    <th width="15%" class="text-center">মোট প্রশিক্ষণ</th>
                                    <th width="22%" class="text-center">অ্যাকশন</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($courses as $index => $course)
                                    <tr>
                                        <td class="text-center">{{ $courses->firstItem() + $index }}.</td>
                                        <td>
                                            <strong class="text-dark">{{ $course->title }}</strong>
                                            @if($course->description)
                                                <br><small class="text-muted">{{ Str::limit($course->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info text-white px-2 py-1">{{ ucfirst($course->type) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary">{{ $course->staff_trainings_count }} টি</span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-outline-primary btn-xs" data-bs-toggle="modal" data-bs-target="#editCourseModal{{ $course->id }}">
                                                <i class="im im-icon-Pen"></i> সম্পাদনা
                                            </button>

                                            {!! Form::open(['route' => ['staffTrainingCourses.destroy', $course->id], 'method' => 'delete', 'style' => 'display:inline']) !!}
                                                {!! Form::button('<i class="im im-icon-Remove"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-xs', 'onclick' => "return confirm('আপনি কি নিশ্চিত?')"]) !!}
                                            {!! Form::close() !!}

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="editCourseModal{{ $course->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog text-start">
                                                    <div class="modal-content">
                                                        {!! Form::model($course, ['route' => ['staffTrainingCourses.update', $course->id], 'method' => 'patch']) !!}
                                                            <div class="modal-header bg-light py-2">
                                                                <h5 class="modal-title font-weight-bold">কোর্স সম্পাদনা করুন</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body p-3">
                                                                <div class="mb-3">
                                                                    {!! Form::label('title', 'কোর্সের নাম:', ['class' => 'form-label font-weight-bold']) !!}
                                                                    {!! Form::text('title', null, ['class' => 'form-control', 'required' => 'required']) !!}
                                                                </div>
                                                                <div class="mb-3">
                                                                    {!! Form::label('type', 'ধরণ:', ['class' => 'form-label font-weight-bold']) !!}
                                                                    {!! Form::select('type', [
                                                                        'local' => 'স্বদেশী (Local)',
                                                                        'foreign' => 'বৈদেশিক (Foreign)',
                                                                        'internal' => 'অভ্যন্তরীণ (Internal)',
                                                                        'external' => 'বহিরাগত (External)',
                                                                        'online' => 'অনলাইন (Online)',
                                                                        'workshop' => 'কর্মশালা / ওয়ার্কশপ'
                                                                    ], null, ['class' => 'form-control']) !!}
                                                                </div>
                                                                <div class="mb-3">
                                                                    {!! Form::label('description', 'বিবরণ:', ['class' => 'form-label font-weight-bold']) !!}
                                                                    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer py-2">
                                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">বন্ধ করুন</button>
                                                                <button type="submit" class="btn btn-primary btn-sm">আপডেট করুন</button>
                                                            </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            কোনো প্রশিক্ষণ কোর্স পাওয়া যায়নি।
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($courses->hasPages())
                    <div class="card-footer bg-white d-flex justify-content-end py-2">
                        {{ $courses->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
