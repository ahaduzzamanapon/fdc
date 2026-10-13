<!-- 🧍 ব্যক্তিগত তথ্য -->

@php
    $departments = \App\Models\Department::all()->pluck('name_bn', 'id')->prepend(__('messages.select_department'), '')->toArray();
    $designations = \App\Models\Designation::all()->pluck('desi_name', 'id')->prepend(__('messages.select_designation'), '')->toArray();
    $divisions = \App\Models\Division::all()->pluck('name_bn', key: 'id')->prepend(__('messages.select_division'), '')->toArray();
    $districts = \App\Models\District::all()->pluck('name_bn', key: 'id')->prepend(__('messages.select_district'), '')->toArray();
@endphp
<div class="col-md-12">
    <h4><strong>🧍 {{ __('messages.personal_information') }}</strong></h4>
    <hr>
    <div class="row">
        <!-- নাম (বাংলা) -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('name_bn', __('messages.name_bengali') . ' ', ['class' => 'control-label']) !!}
                <span style="color:red">*</span>
                {!! Form::text('name_bn', null, ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>

        <!-- নাম (ইংরেজি) -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('name_en', __('messages.name_english'), ['class' => 'control-label']) !!}
                {!! Form::text('name_en', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- লিঙ্গ -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('gender', __('messages.gender'), ['class' => 'control-label']) !!}
                <span style="color:red">*</span>
                {!! Form::select('gender', [__('messages.male') => __('messages.male'), __('messages.female') => __('messages.female'), __('messages.general') => __('messages.general')], null, ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>

        <!-- ধর্ম -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('religion', __('messages.religion'), ['class' => 'control-label']) !!}
                {!! Form::select('religion', [__('messages.islam') => __('messages.islam'), __('messages.hindu') => __('messages.hindu'), __('messages.christian') => __('messages.christian'), __('messages.buddhist') => __('messages.buddhist'), __('messages.other') => __('messages.other')], null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- পিতার নাম -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('father_name', __('messages.father_name'), ['class' => 'control-label']) !!}
                {!! Form::text('father_name', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- মাতার নাম -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('mother_name', __('messages.mother_name'), ['class' => 'control-label']) !!}
                {!! Form::text('mother_name', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- জন্ম তারিখ -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('dob', __('messages.date_of_birth'), ['class' => 'control-label']) !!}
                <span style="color:red">*</span>
                {!! Form::date('dob', null, ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>

        <!-- এনআইডি -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('nid', __('messages.nid'), ['class' => 'control-label']) !!}
                {!! Form::text('nid', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- মোবাইল নম্বর -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('mobile_no', __('messages.mobile_number'), ['class' => 'control-label']) !!}
                <span style="color:red">*</span>
                {!! Form::text('mobile_no', null, ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>

        <!-- ইমেল -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('email', __('messages.email_label'), ['class' => 'control-label']) !!}
                {!! Form::email('email', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- রক্তের গ্রুপ -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('blood_group', __('messages.blood_group'), ['class' => 'control-label']) !!}
                {!! Form::select('blood_group', ['A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-', 'O+' => 'O+', 'O-' => 'O-'], null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- শিক্ষাগত যোগ্যতা -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('highest_qualification', __('messages.highest_educational_qualification'), ['class' => 'control-label']) !!}
                {!! Form::text('highest_qualification', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- বৈবাহিক অবস্থা -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('marital_status', __('messages.marital_status'), ['class' => 'control-label']) !!}
                {!! Form::select('marital_status', [__('messages.unmarried') => __('messages.unmarried'), __('messages.married') => __('messages.married')], null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- সন্তানের সংখ্যা -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('no_of_child', __('messages.number_of_children'), ['class' => 'control-label']) !!}
                {!! Form::number('no_of_child', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- মুক্তিযোদ্ধা অবস্থা  -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('freedom_fighter', __('messages.freedom_fighter'), ['class' => 'control-label']) !!}
                {!! Form::select('freedom_fighter', [__('messages.no') => __('messages.no'), __('messages.yes') => __('messages.yes')], null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- ইউজার আইডি (লগইন আইডি) -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('username', __('messages.username') . ' (আইডি)', ['class' => 'control-label']) !!}
                {!! Form::text('username', null, ['class' => 'form-control', 'readonly' => true, 'style' => 'background-color: #f1f3f5; font-weight: 600; cursor: not-allowed;']) !!}
                <small class="text-muted">লগইন আইডি অপরিবর্তনযোগ্য</small>
            </div>
        </div>
    </div>
</div>

<!-- 🏠 স্থায়ী ঠিকানা তথ্য -->
<div class="col-md-12 mt-4">
    <h4><strong>🏠 {{ __('messages.permanent_address') }}</strong></h4>
    <hr>
    <div class="row">
        <!-- বিভাগ আইডি -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('div_id', __('messages.division_label'), ['class' => 'control-label']) !!}
                <span style="color:red">*</span>
                {!! Form::select('div_id', $divisions, null, ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>

        <!-- জেলা আইডি -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('dis_id', __('messages.district_label'), ['class' => 'control-label']) !!}
                <span style="color:red">*</span>
                @php
                    $permanent_districts = ['' => __('messages.select_district')];
                    if (isset($users) && $users->div_id) {
                        $permanent_districts = \App\Models\District::where('division_id', $users->div_id)->pluck('name_bn', 'id')->prepend(__('messages.select_district'), '')->toArray();
                    }
                @endphp
                {!! Form::select('dis_id', $permanent_districts, null, ['class' => 'form-control', 'required' => true]) !!}
            </div>
        </div>

        <!-- Upazila Id Field -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('upazila_id', __('messages.upazila_label'), ['class' => 'control-label']) !!}
                <span style="color:red">*</span>
                @php
                    $permanent_upazilas = ['' => __('messages.select_upazila')];
                    if (isset($users) && $users->dis_id) {
                        $permanent_upazilas = \App\Models\Upazila::where('dis_id', $users->dis_id)->pluck('name_bn', 'id')->prepend(__('messages.select_upazila'), '')->toArray();
                    }
                @endphp
                {!! Form::select('upazila_id', $permanent_upazilas, null, ['class' => 'form-control select2', 'required' => true]) !!}
            </div>
        </div>

        <!-- গ্রাম / মহল্লা -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('village', __('messages.village_locality'), ['class' => 'control-label']) !!}
                <span style="color:red">*</span>
                {!! Form::textarea('village', null, ['class' => 'form-control', 'rows' => 2, 'required' => true]) !!}
            </div>
        </div>
    </div>
</div>

<!-- 📍 বর্তমান ঠিকানা তথ্য -->
<div class="col-md-12 mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h4><strong>📍 {{ __('messages.present_address') }}</strong></h4>
        <div class="form-check form-check-inline" style="font-size: 15px; cursor: pointer;">
            <input class="form-check-input" type="checkbox" id="same_as_permanent" style="cursor: pointer; transform: scale(1.2); margin-right: 6px;">
            <label class="form-check-label" for="same_as_permanent" style="cursor: pointer; font-weight: 600; color: #2c3e50;">
                {{ __('messages.same_as_permanent_address') }}
            </label>
        </div>
    </div>
    <hr>
    <div class="row">
        <!-- বিভাগ আইডি -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('present_div_id', __('messages.division_label'), ['class' => 'control-label']) !!}
                {!! Form::select('present_div_id', $divisions, null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- জেলা আইডি -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('present_dis_id', __('messages.district_label'), ['class' => 'control-label']) !!}
                @php
                    $present_districts = ['' => __('messages.select_district')];
                    if (isset($users) && $users->present_div_id) {
                        $present_districts = \App\Models\District::where('division_id', $users->present_div_id)->pluck('name_bn', 'id')->prepend(__('messages.select_district'), '')->toArray();
                    }
                @endphp
                {!! Form::select('present_dis_id', $present_districts, null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- Upazila Id Field -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('present_upazila_id', __('messages.upazila_label'), ['class' => 'control-label']) !!}
                @php
                    $present_upazilas = ['' => __('messages.select_upazila')];
                    if (isset($users) && $users->present_dis_id) {
                        $present_upazilas = \App\Models\Upazila::where('dis_id', $users->present_dis_id)->pluck('name_bn', 'id')->prepend(__('messages.select_upazila'), '')->toArray();
                    }
                @endphp
                {!! Form::select('present_upazila_id', $present_upazilas, null, ['class' => 'form-control select2']) !!}
            </div>
        </div>

        <!-- গ্রাম / মহল্লা -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('present_village', __('messages.village_locality'), ['class' => 'control-label']) !!}
                {!! Form::textarea('present_village', null, ['class' => 'form-control', 'rows' => 2]) !!}
            </div>
        </div>
    </div>
</div>

<!-- 🔐 ছবি, স্বাক্ষর ও নিরাপত্তা -->
<div class="col-md-12 mt-4">
    <h4><strong>📸 ছবি, স্বাক্ষর ও নিরাপত্তা</strong></h4>
    <hr>
    <div class="row">
        <!-- পাসওয়ার্ড -->
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('password', __('messages.password_label'), ['class' => 'control-label']) !!}
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'পাসওয়ার্ড পরিবর্তন করতে চাইলে লিখুন']) !!}
            </div>
        </div>

        <!-- ছবি -->
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('picture', __('messages.picture'), ['class' => 'control-label']) !!}
                {!! Form::file('picture', ['onchange' => 'previewImage(event, "imagePreview")', 'accept' => 'image/*']) !!}
                @php
                    $pictureSrc = '';
                    if (isset($users) && $users->picture && $users->picture !== 'no-image.png') {
                        $pictureSrc = \Illuminate\Support\Str::startsWith($users->picture, 'picture/user/') ? asset($users->picture) : asset('picture/user/' . $users->picture);
                    }
                @endphp
                <img id="imagePreview" src="{{ $pictureSrc }}" alt="Image Preview"
                    style="{{ !empty($pictureSrc) ? '' : 'display: none;' }}margin-top:10px;max-width: 45%;height:auto;" />
            </div>
        </div>

        <!-- স্বাক্ষর -->
        <div class="col-md-4">
            <div class="form-group">
                {!! Form::label('signature', __('messages.signature'), ['class' => 'control-label']) !!}
                {!! Form::file('signature', ['onchange' => 'previewImage(event, "signaturePreview")', 'accept' => 'image/*']) !!}
                @php
                    $signatureSrc = '';
                    if (isset($users) && $users->signature && $users->signature !== 'no-image.png') {
                        $signatureSrc = \Illuminate\Support\Str::startsWith($users->signature, 'images/signature/') ? asset($users->signature) : asset('images/signature/' . $users->signature);
                    }
                @endphp
                <img id="signaturePreview" src="{{ $signatureSrc }}"
                    alt="Signature Preview"
                    style="{{ !empty($signatureSrc) ? '' : 'display: none;' }}margin-top:10px;max-width: 45%;height:auto;" />
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event, previewId) {
        var file = event.target.files[0];
        var reader = new FileReader();
        reader.onload = function () {
            document.getElementById(previewId).src = reader.result;
            document.getElementById(previewId).style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
</script>
<div class="clearfix"></div>

<!-- জমা দিন -->
<div class="form-group col-sm-12 mt-4" style="text-align-last: right;">
    {!! Form::submit(__('messages.save_profile'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('profile.index') }}" class="btn btn-danger">{{ __('messages.cancel_profile') }}</a>
</div>

@section('footer_scripts')
    <script>
        $(document).ready(function () {
            // Function to sync present address with permanent address
            function syncAddress() {
                if (!$('#same_as_permanent').is(':checked')) {
                    return;
                }

                var divId = $('#div_id').val();
                var village = $('#village').val();

                $('#present_village').val(village);

                if (divId) {
                    $('#present_div_id').val(divId);

                    // Copy district options and selection
                    $('#present_dis_id').empty();
                    $('#dis_id option').each(function () {
                        $('#present_dis_id').append($(this).clone());
                    });
                    $('#present_dis_id').val($('#dis_id').val());

                    // Copy upazila options and selection
                    $('#present_upazila_id').empty();
                    $('#upazila_id option').each(function () {
                        $('#present_upazila_id').append($(this).clone());
                    });
                    $('#present_upazila_id').val($('#upazila_id').val()).trigger('change');
                } else {
                    $('#present_div_id').val('');
                    $('#present_dis_id').empty().append('<option value="">জেলা নির্বাচন করুন</option>');
                    $('#present_upazila_id').empty().append('<option value="">উপজেলা নির্বাচন করুন</option>').trigger('change');
                }
            }

            // Division -> District
            $('#div_id').change(function () {
                var divisionId = $(this).val();
                if (divisionId) {
                    $.ajax({
                        url: "{{ route('get_districts') }}",
                        type: "GET",
                        data: { division_id: divisionId },
                        success: function (data) {
                            $('#dis_id').empty();
                            $('#dis_id').append('<option value="">জেলা নির্বাচন করুন</option>');
                            $.each(data, function (index, district) {
                                $('#dis_id').append('<option value="' + district.id + '">' + district.name + '</option>');
                            });
                            $('#upazila_id').empty();
                            $('#upazila_id').append('<option value="">উপজেলা নির্বাচন করুন</option>').trigger('change');

                            if ($('#same_as_permanent').is(':checked')) {
                                syncAddress();
                            }
                        }
                    });
                } else {
                    $('#dis_id').empty().append('<option value="">জেলা নির্বাচন করুন</option>');
                    $('#upazila_id').empty().append('<option value="">উপজেলা নির্বাচন করুন</option>').trigger('change');
                    if ($('#same_as_permanent').is(':checked')) {
                        syncAddress();
                    }
                }
            });

            // District -> Upazila
            $('#dis_id').change(function () {
                var districtId = $(this).val();
                if (districtId) {
                    $.ajax({
                        url: "{{ route('get_upazilas') }}",
                        type: "GET",
                        data: { district_id: districtId },
                        success: function (data) {
                            $('#upazila_id').empty();
                            $('#upazila_id').append('<option value="">উপজেলা নির্বাচন করুন</option>');
                            $.each(data, function (index, upajila) {
                                $('#upazila_id').append('<option value="' + upajila.id + '">' + upajila.name + '</option>');
                            });
                            $('#upazila_id').trigger('change');

                            if ($('#same_as_permanent').is(':checked')) {
                                syncAddress();
                            }
                        }
                    });
                } else {
                    $('#upazila_id').empty().append('<option value="">উপজেলা নির্বাচন করুন</option>').trigger('change');
                    if ($('#same_as_permanent').is(':checked')) {
                        syncAddress();
                    }
                }
            });

            // When permanent upazila or village changes
            $('#upazila_id').change(function () {
                if ($('#same_as_permanent').is(':checked')) {
                    $('#present_upazila_id').val($(this).val()).trigger('change');
                }
            });

            $('#village').on('input change', function () {
                if ($('#same_as_permanent').is(':checked')) {
                    $('#present_village').val($(this).val());
                }
            });

            // Toggle same_as_permanent checkbox
            $('#same_as_permanent').change(function () {
                if ($(this).is(':checked')) {
                    syncAddress();
                }
            });

            // Auto-check on page load if present address matches permanent address
            var pDiv = $('#present_div_id').val();
            var div = $('#div_id').val();
            var pDis = $('#present_dis_id').val();
            var dis = $('#dis_id').val();
            var pUpa = $('#present_upazila_id').val();
            var upa = $('#upazila_id').val();
            var pVil = $('#present_village').val();
            var vil = $('#village').val();
            if (div && pDiv && div === pDiv && dis && pDis && dis === pDis && upa && pUpa && upa === pUpa && pVil === vil) {
                $('#same_as_permanent').prop('checked', true);
            }

            // Present Division -> Present District
            $('#present_div_id').change(function () {
                var divisionId = $(this).val();
                if (divisionId) {
                    $.ajax({
                        url: "{{ route('get_districts') }}",
                        type: "GET",
                        data: { division_id: divisionId },
                        success: function (data) {
                            $('#present_dis_id').empty();
                            $('#present_dis_id').append('<option value="">জেলা নির্বাচন করুন</option>');
                            $.each(data, function (index, district) {
                                $('#present_dis_id').append('<option value="' + district.id + '">' + district.name + '</option>');
                            });
                            $('#present_upazila_id').empty();
                            $('#present_upazila_id').append('<option value="">উপজেলা নির্বাচন করুন</option>').trigger('change');
                        }
                    });
                } else {
                    $('#present_dis_id').empty().append('<option value="">জেলা নির্বাচন করুন</option>');
                    $('#present_upazila_id').empty().append('<option value="">উপজেলা নির্বাচন করুন</option>').trigger('change');
                }
            });

            // Present District -> Present Upazila
            $('#present_dis_id').change(function () {
                var districtId = $(this).val();
                if (districtId) {
                    $.ajax({
                        url: "{{ route('get_upazilas') }}",
                        type: "GET",
                        data: { district_id: districtId },
                        success: function (data) {
                            $('#present_upazila_id').empty();
                            $('#present_upazila_id').append('<option value="">উপজেলা নির্বাচন করুন</option>');
                            $.each(data, function (index, upajila) {
                                $('#present_upazila_id').append('<option value="' + upajila.id + '">' + upajila.name + '</option>');
                            });
                            $('#present_upazila_id').trigger('change');
                        }
                    });
                } else {
                    $('#present_upazila_id').empty().append('<option value="">উপজেলা নির্বাচন করুন</option>').trigger('change');
                }
            });
        });
    </script>
@endsection
