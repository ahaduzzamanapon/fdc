<div class="row">
    <!-- User Select (if Admin / HR) -->
    @if(!who('staff'))
        <div class="col-md-6 mb-3">
            {!! Form::label('user_id', 'কর্মকর্তা / কর্মচারী:', ['class' => 'form-label font-weight-bold']) !!} <span class="text-danger">*</span>
            {!! Form::select('user_id', $users, null, ['class' => 'form-control select2', 'required' => 'required']) !!}
            @error('user_id')
                <small class="text-danger d-block">{{ $message }}</small>
            @enderror
        </div>
    @else
        <div class="col-md-6 mb-3">
            {!! Form::label('user_name', 'কর্মকর্তা / কর্মচারী:', ['class' => 'form-label font-weight-bold']) !!}
            <input type="text" class="form-control" value="{{ Auth::user()->name_bn ?? Auth::user()->name_en }}" readonly>
        </div>
    @endif

    <!-- Training Course Select + Add Course Button -->
    <div class="col-md-6 mb-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <label for="training_id" class="form-label font-weight-bold mb-0">
                প্রশিক্ষণ কোর্স / বিষয়সূচী: <span class="text-danger">*</span>
            </label>
            <button type="button" class="btn btn-xs btn-outline-success font-weight-bold" data-bs-toggle="modal" data-bs-target="#addCourseModal" data-toggle="modal" data-target="#addCourseModal">
                <i class="im im-icon-Add"></i> + নতুন কোর্স যোগ করুন
            </button>
        </div>
        {!! Form::select('training_id', $courses, null, ['class' => 'form-control select2', 'id' => 'training_id', 'required' => 'required']) !!}
        @error('training_id')
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    </div>

    <!-- Start Date -->
    <div class="col-md-4 mb-3">
        {!! Form::label('start_date', 'শুরুর তারিখ:', ['class' => 'form-label font-weight-bold']) !!} <span class="text-danger">*</span>
        {!! Form::date('start_date', isset($training) && $training->start_date ? $training->start_date->format('Y-m-d') : null, ['class' => 'form-control', 'id' => 'start_date', 'required' => 'required']) !!}
        @error('start_date')
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    </div>

    <!-- End Date -->
    <div class="col-md-4 mb-3">
        {!! Form::label('end_date', 'সমাপ্তির তারিখ:', ['class' => 'form-label font-weight-bold']) !!} <span class="text-danger">*</span>
        {!! Form::date('end_date', isset($training) && $training->end_date ? $training->end_date->format('Y-m-d') : null, ['class' => 'form-control', 'id' => 'end_date', 'required' => 'required']) !!}
        @error('end_date')
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    </div>

    <!-- Duration (Auto calculated) -->
    <div class="col-md-4 mb-3">
        {!! Form::label('duration', 'মেয়াদকাল (সময়সীমা):', ['class' => 'form-label font-weight-bold']) !!}
        {!! Form::text('duration', null, ['class' => 'form-control', 'id' => 'duration', 'placeholder' => 'তারিখ নির্বাচন করলে স্বয়ংক্রিয়ভাবে হিসাব হবে', 'readonly' => 'readonly']) !!}
    </div>

    <!-- Institute -->
    <div class="col-md-6 mb-3">
        {!! Form::label('institute', 'ইনস্টিটিউট / প্রতিষ্ঠান / সংস্থা:', ['class' => 'form-label font-weight-bold']) !!} <span class="text-danger">*</span>
        {!! Form::text('institute', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'যেমন: BPATC, NAEM, বিএফডিসি বা অন্য প্রতিষ্ঠান']) !!}
        @error('institute')
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    </div>

    <!-- Location -->
    <div class="col-md-6 mb-3">
        {!! Form::label('location', 'স্থান / দেশ:', ['class' => 'form-label font-weight-bold']) !!}
        {!! Form::text('location', null, ['class' => 'form-control', 'placeholder' => 'যেমন: ঢাকা, গাজীপুর, ভারত, অনলাইন']) !!}
    </div>

    <!-- Result / Grade -->
    <div class="col-md-6 mb-3">
        {!! Form::label('result_grade', 'ফলাফল / গ্রেড / অবস্থা:', ['class' => 'form-label font-weight-bold']) !!}
        {!! Form::text('result_grade', null, ['class' => 'form-control', 'placeholder' => 'যেমন: উত্তীর্ণ, A+, সন্তোষজনক, অংশগ্রহণমূলক']) !!}
    </div>

    <!-- Certificate File -->
    <div class="col-md-6 mb-3">
        {!! Form::label('certificate_file', 'সনদপত্র সংযুক্তি (PDF/Image):', ['class' => 'form-label font-weight-bold']) !!}
        {!! Form::file('certificate_file', ['class' => 'form-control', 'accept' => '.pdf,.jpg,.jpeg,.png']) !!}
        @if(isset($training) && $training->certificate_file)
            <small class="d-block mt-1">
                বর্তমান সনদপত্র: <a href="{{ asset($training->certificate_file) }}" target="_blank" class="text-primary font-weight-bold">দেখুন / ডাউনলোড করুন</a>
            </small>
        @endif
        @error('certificate_file')
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    </div>

    <!-- Remarks -->
    <div class="col-md-12 mb-4">
        {!! Form::label('remarks', 'মন্তব্য / বিস্তারিত বিবরণ:', ['class' => 'form-label font-weight-bold']) !!}
        {!! Form::textarea('remarks', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => 'প্রশিক্ষণ সম্পর্কিত অতিরিক্ত কোনো তথ্য বা মন্তব্য']) !!}
    </div>
</div>

<div class="d-flex gap-2">
    {!! Form::submit('সংরক্ষণ করুন', ['class' => 'btn text-white font-weight-bold px-4', 'style' => 'background-color: #1f9303 !important; border: none;']) !!}
    <a href="{{ route('staffTrainings.index') }}" class="btn btn-secondary px-4">বাতিল করুন</a>
</div>

<!-- Modal for Quick Add Course -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-start">
            <div class="modal-header py-2 text-white" style="background-color: #8dc542 !important;">
                <h5 class="modal-title font-weight-bold" id="addCourseModalLabel"><i class="im im-icon-Add me-2"></i>নতুন প্রশিক্ষণ কোর্স যুক্ত করুন</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3">
                <div id="quickCourseAlert" class="alert d-none py-2 px-3 mb-3"></div>
                <div class="mb-3">
                    <label class="form-label font-weight-bold">কোর্সের নাম / শিরোনাম: <span class="text-danger">*</span></label>
                    <input type="text" id="quick_course_title" class="form-control" placeholder="যেমন: বুনিয়াদী প্রশিক্ষণ, ডিজিটাল সার্ভিস ডেলিভারি ইত্যাদি">
                </div>
                <div class="mb-3">
                    <label class="form-label font-weight-bold">কোর্সের ধরণ:</label>
                    <select id="quick_course_type" class="form-control">
                        <option value="local">স্বদেশী (Local)</option>
                        <option value="foreign">বৈদেশিক (Foreign)</option>
                        <option value="internal">অভ্যন্তরীণ (Internal)</option>
                        <option value="external">বহিরাগত (External)</option>
                        <option value="online">অনলাইন (Online)</option>
                        <option value="workshop">কর্মশালা / ওয়ার্কশপ</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label font-weight-bold">সংক্ষিপ্ত বিবরণ:</label>
                    <textarea id="quick_course_desc" class="form-control" rows="2" placeholder="কোর্সের সংক্ষেপ বিবরণ (ঐচ্ছিক)"></textarea>
                </div>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" data-dismiss="modal">বন্ধ করুন</button>
                <button type="button" id="saveQuickCourseBtn" class="btn text-white btn-sm" style="background-color: #1f9303 !important;">সংরক্ষণ করুন</button>
            </div>
        </div>
    </div>
</div>

@section('footer_scripts')
<script>
    $(document).ready(function() {
        // Auto Calculate Duration in Bengali digits
        function calculateDuration() {
            var startVal = $('#start_date').val();
            var endVal = $('#end_date').val();

            if (startVal && endVal) {
                var start = new Date(startVal);
                var end = new Date(endVal);

                if (end >= start) {
                    var diffTime = Math.abs(end - start);
                    var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; // inclusive of start day

                    var bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
                    var durationText = '';

                    if (diffDays >= 30) {
                        var months = Math.floor(diffDays / 30);
                        var remDays = diffDays % 30;
                        var monthsBn = months.toString().replace(/\d/g, function(d) { return bengaliDigits[d]; });
                        durationText = monthsBn + ' মাস';
                        if (remDays > 0) {
                            var remDaysBn = remDays.toString().replace(/\d/g, function(d) { return bengaliDigits[d]; });
                            durationText += ' ' + remDaysBn + ' দিন';
                        }
                    } else {
                        var daysBn = diffDays.toString().replace(/\d/g, function(d) { return bengaliDigits[d]; });
                        durationText = daysBn + ' দিন';
                    }

                    $('#duration').val(durationText);
                } else {
                    $('#duration').val('');
                }
            }
        }

        $('#start_date, #end_date').on('change input', calculateDuration);
        if ($('#start_date').val() && $('#end_date').val() && !$('#duration').val()) {
            calculateDuration();
        }

        // Quick Add Course via AJAX
        $('#saveQuickCourseBtn').on('click', function() {
            var title = $('#quick_course_title').val().trim();
            var type = $('#quick_course_type').val();
            var desc = $('#quick_course_desc').val();

            if (!title) {
                $('#quickCourseAlert').removeClass('d-none alert-success').addClass('alert-danger').text('কোর্সের নাম প্রদান করুন।');
                return;
            }

            $.ajax({
                url: "{{ route('staffTrainingCourses.storeAjax') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    title: title,
                    type: type,
                    description: desc
                },
                success: function(response) {
                    if (response.success) {
                        var newOption = new Option(response.course.title, response.course.id, true, true);
                        $('#training_id').append(newOption).trigger('change');

                        $('#quick_course_title').val('');
                        $('#quick_course_desc').val('');
                        $('#quickCourseAlert').addClass('d-none');
                        
                        // Close modal for Bootstrap 4 & 5
                        $('#addCourseModal').modal('hide');
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open').css('padding-right', '');
                    } else {
                        $('#quickCourseAlert').removeClass('d-none alert-success').addClass('alert-danger').text(response.message || 'কোর্স যোগ করতে সমস্যা হয়েছে।');
                    }
                },
                error: function(xhr) {
                    var msg = 'কোর্স যোগ করতে ব্যর্থ হয়েছে।';
                    if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.title) {
                        msg = xhr.responseJSON.errors.title[0];
                    }
                    $('#quickCourseAlert').removeClass('d-none alert-success').addClass('alert-danger').text(msg);
                }
            });
        });
    });
</script>
@endsection
