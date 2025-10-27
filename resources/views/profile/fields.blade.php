<!-- 🧍 ব্যক্তিগত তথ্য -->

@php
    $departments = \App\Models\Department::all()->pluck('name_bn', 'id')->prepend(__('messages.select_department'), '')->toArray();
    $designations = \App\Models\Designation::all()->pluck('desi_name', 'id')->prepend(__('messages.select_designation'), '')->toArray();
    $districts = \App\Models\District::all()->pluck('name_en', key: 'id')->prepend(__('messages.select_district'), '')->toArray();
    $userRoles = \App\Models\RoleAndPermission::all()->pluck('name', key: 'id')->prepend(__('messages.select_role'), '')->toArray();
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
                {!! Form::text('name_bn', old('name_bn'), ['class' => 'form-control', 'required' => true]) !!}
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

        <!-- মুক্তিযোদ্ধা অবস্থা -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('freedom_fighter', __('messages.freedom_fighter'), ['class' => 'control-label']) !!}
                {!! Form::select('freedom_fighter', [__('messages.yes') => __('messages.yes'), __('messages.no') => __('messages.no')], null, ['class' => 'form-control']) !!}
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

        <!-- সর্বোচ্চ শিক্ষাগত যোগ্যতা -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('highest_qualification', __('messages.highest_educational_qualification'), ['class' => 'control-label']) !!}
                {!! Form::text('highest_qualification', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- জেলা আইডি -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('dis_id', __('messages.district_label'), ['class' => 'control-label']) !!}
                {!! Form::select('dis_id', $districts, null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- Upazila Id Field -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('upazila_id', __('messages.upazila_label'), ['class' => 'control-label']) !!}
                {!! Form::select('upazila_id', ['' => __('messages.select_upazila')], null, ['class' => 'form-control select2']) !!}
            </div>
        </div>

        <!-- গ্রাম / মহল্লা -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('present_add', __('messages.village_locality'), ['class' => 'control-label']) !!}
                {!! Form::textarea('present_add', null, ['class' => 'form-control', 'rows' => 3]) !!}
            </div>
        </div>

        <!-- মন্তব্য -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('note', __('messages.remark_label'), ['class' => 'control-label']) !!}
                {!! Form::textarea('note', null, ['class' => 'form-control', 'rows' => 3]) !!}
            </div>
        </div>
    </div>
</div>


        <!-- পাসওয়ার্ড -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('password', __('messages.password_label'), ['class' => 'control-label']) !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- ছবি -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('picture', __('messages.picture'), ['class' => 'control-label']) !!}
                {!! Form::file('picture', ['onchange' => 'previewImage(event, "imagePreview")', 'accept' => 'image/*']) !!}
                <img id="imagePreview" src="{{ isset($users) ? asset($users->image) : '' }}" alt="Image Preview"
                    style="{{ isset($users) && $users->image ? '' : 'display: none;' }}margin-top:10px;max-width: 45%;height:auto;" />
            </div>
        </div>

        <!-- স্বাক্ষর -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('signature', __('messages.signature'), ['class' => 'control-label']) !!}
                {!! Form::file('signature', ['onchange' => 'previewImage(event, "signaturePreview")', 'accept' => 'image/*']) !!}
                <img id="signaturePreview" src="{{ isset($users) ? asset($users->signature) : '' }}"
                    alt="Signature Preview"
                    style="{{ isset($users) && $users->image ? '' : 'display: none;' }}margin-top:10px;max-width: 45%;height:auto;" />
            </div>
        </div>
    </div>
</div>

<!-- ছবি ও স্বাক্ষর -->
{{-- <div class="col-md-12 mt-4">
    <h4><strong>📸 ছবি ও স্বাক্ষর</strong></h4>
    <hr>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('picture', 'ছবি', ['class' => 'control-label']) !!}
                {!! Form::file('picture', ['onchange' => 'previewImage(event, "imagePreview")', 'accept' => 'image/*']) !!}
                <img id="imagePreview" src="{{ isset($users) ? asset($users->image) : '' }}" alt="Image Preview"
                    style="{{ isset($users) && $users->image ? '' : 'display: none;' }}margin-top:10px;max-width: 45%;height:auto;" />
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('signature', 'স্বাক্ষর', ['class' => 'control-label']) !!}
                {!! Form::file('signature', ['onchange' => 'previewImage(event, "signaturePreview")', 'accept' => 'image/*']) !!}
                <img id="signaturePreview" src="{{ isset($users) ? asset($users->signature) : '' }}"
                    alt="Signature Preview"
                    style="{{ isset($users) && $users->image ? '' : 'display: none;' }}margin-top:10px;max-width: 45%;height:auto;" />
            </div>
        </div>
    </div>
</div> --}}

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
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit(__('messages.save_profile'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('profile.index') }}" class="btn btn-danger">{{ __('messages.cancel_profile') }}</a>
</div>


@section('footer_scripts')
    <script>
        $(document).ready(function() {
            $('#dis_id').change(function() {
                var districtId = $(this).val();
                $.ajax({
                    url: "{{ route('get_upazilas') }}",
                    type: "GET",
                    data: {
                        district_id: districtId
                    },
                    success: function(data) {
                        $('#upazila_id').empty();
                        $('#upazila_id').append('<option value="">উপজেলা নির্বাচন করুন</option>');
                        $.each(data, function(index, upajila) {
                            $('#upazila_id').append('<option value="' + upajila.id + '">' + upajila.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
@endsection
