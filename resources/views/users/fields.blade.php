<!-- 🧍 ব্যক্তিগত তথ্য -->

@php
    $designations = \App\Models\Designation::all()->pluck('desi_name', 'id')->prepend('Select Designation', '')->toArray();
    $districts = \App\Models\District::all()->pluck('name_en', key: 'id')->prepend('Select District', '')->toArray();
@endphp
<div class="col-md-12">
    <h4><strong>🧍 ব্যক্তিগত তথ্য</strong></h4>
    <hr>
    <div class="row">
        <!-- নাম (বাংলা) -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('name_bn', 'নাম (বাংলা)', ['class' => 'control-label']) !!}
                {!! Form::text('name_bn', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- নাম (ইংরেজি) -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('name_en', 'নাম (ইংরেজি)', ['class' => 'control-label']) !!}
                {!! Form::text('name_en', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- লিঙ্গ -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('gender', 'লিঙ্গ', ['class' => 'control-label']) !!}
                {!! Form::select('gender', ['পুরুষ' => 'পুরুষ', 'মহিলা' => 'মহিলা'], null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- ধর্ম -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('religion', 'ধর্ম', ['class' => 'control-label']) !!}
                {!! Form::select('religion', ['ইসলাম' => 'ইসলাম', 'হিন্দু' => 'হিন্দু', 'খ্রিস্টান' => 'খ্রিস্টান', 'বৌদ্ধ' => 'বৌদ্ধ', 'অন্যান্য' => 'অন্যান্য'], null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- পিতার নাম -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('father_name', 'পিতার নাম', ['class' => 'control-label']) !!}
                {!! Form::text('father_name', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- মাতার নাম -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('mother_name', 'মাতার নাম', ['class' => 'control-label']) !!}
                {!! Form::text('mother_name', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- জন্ম তারিখ -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('dob', 'জন্ম তারিখ', ['class' => 'control-label']) !!}
                {!! Form::date('dob', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- এনআইডি -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('nid', 'এনআইডি', ['class' => 'control-label']) !!}
                {!! Form::text('nid', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- মোবাইল নম্বর -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('mobile_no', 'মোবাইল নম্বর', ['class' => 'control-label']) !!}
                {!! Form::text('mobile_no', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- ইমেল -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('email', 'ইমেল', ['class' => 'control-label']) !!}
                {!! Form::email('email', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- রক্তের গ্রুপ -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('blood_group', 'রক্তের গ্রুপ', ['class' => 'control-label']) !!}
                {!! Form::select('blood_group', ['A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'AB+' => 'AB+', 'AB-' => 'AB-', 'O+' => 'O+', 'O-' => 'O-'], null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- বৈবাহিক অবস্থা -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('marital_status', 'বৈবাহিক অবস্থা', ['class' => 'control-label']) !!}
                {!! Form::select('marital_status', ['অবিবাহিত' => 'অবিবাহিত', 'বিবাহিত' => 'বিবাহিত'], null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- সন্তানের সংখ্যা -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('no_of_child', 'সন্তানের সংখ্যা', ['class' => 'control-label']) !!}
                {!! Form::number('no_of_child', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- সর্বোচ্চ শিক্ষাগত যোগ্যতা -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('highest_qualification', 'সর্বোচ্চ শিক্ষাগত যোগ্যতা', ['class' => 'control-label']) !!}
                {!! Form::text('highest_qualification', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- জেলা আইডি -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('dis_id', 'জেলা', ['class' => 'control-label']) !!}
                {!! Form::select('dis_id', $districts, null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- বর্তমান ঠিকানা -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('present_add', 'বর্তমান ঠিকানা', ['class' => 'control-label']) !!}
                {!! Form::text('present_add', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- নোট -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('note', 'নোট', ['class' => 'control-label']) !!}
                {!! Form::textarea('note', null, ['class' => 'form-control', 'rows' => 3]) !!}
            </div>
        </div>
    </div>
</div>

<!-- 🏢 দাপ্তরিক তথ্য -->
<div class="col-md-12 mt-4">
    <h4><strong>🏢 দাপ্তরিক তথ্য</strong></h4>
    <hr>
    <div class="row">
        <!-- কর্মচারীর ধরন -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('employee_type', 'কর্মচারীর ধরন', ['class' => 'control-label']) !!}
                {!! Form::select('employee_type', ['কর্মকর্তা' => 'কর্মকর্তা', 'প্রডিউসার' => 'প্রডিউসার'], null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- যোগদানের তারিখ -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('join_date', 'যোগদানের তারিখ', ['class' => 'control-label']) !!}
                {!! Form::date('join_date', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- গ্রেড -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('grade', 'গ্রেড', ['class' => 'control-label']) !!}
                {!! Form::select('grade', [
    '1' => 'প্রথম গ্রেড',
    '2' => 'দ্বিতীয় গ্রেড',
    '3' => 'তৃতীয় গ্রেড',
    '4' => 'চতুর্থ গ্রেড',
    '5' => 'পঞ্চম গ্রেড',
    '6' => 'ষষ্ঠ গ্রেড',
    '7' => 'সপ্তম গ্রেড',
    '8' => 'অষ্টম গ্রেড',
    '9' => 'নবম গ্রেড',
    '10' => 'দশম গ্রেড',
    '11' => 'একাদশ গ্রেড',
    '12' => 'দ্বাদশ গ্রেড',
    '13' => 'ত্রয়োদশ গ্রেড',
    '14' => 'চতুর্দশ গ্রেড',
    '15' => 'পঞ্চদশ গ্রেড',
    '16' => 'ষোড়শ গ্রেড',
], null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- পদবী -->
        <div class="col-md-3">
            <div class="form-group">

                {!! Form::label('designation', 'পদবী', ['class' => 'control-label']) !!}
                {!! Form::select('designation', $designations, null, ['class' => 'form-control']) !!}
            </div>
        </div>


        <!-- বেসিক বেতন -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('basic_salary', 'বেসিক বেতন', ['class' => 'control-label']) !!}
                {!! Form::number('basic_salary', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- বর্তমান অবস্থা -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('current_status', 'বর্তমান অবস্থা', ['class' => 'control-label']) !!}
                {!! Form::select('current_status', ['active' => 'সক্রিয়', 'inactive' => 'নিষ্ক্রিয়'], null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- ব্যবহারকারীর নাম -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('username', 'ব্যবহারকারীর নাম', ['class' => 'control-label']) !!}
                {!! Form::text('username', null, ['class' => 'form-control']) !!}
            </div>
        </div>

        <!-- পাসওয়ার্ড -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('password', 'পাসওয়ার্ড', ['class' => 'control-label']) !!}
                {!! Form::password('password', ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>

<!-- ছবি ও স্বাক্ষর -->
<div class="col-md-12 mt-4">
    <h4><strong>📸 ছবি ও স্বাক্ষর</strong></h4>
    <hr>
    <div class="row">
        <!-- ছবি -->
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('picture', 'ছবি', ['class' => 'control-label']) !!}
                {!! Form::file('picture', ['onchange' => 'previewImage(event, "imagePreview")', 'accept' => 'image/*']) !!}
                <img id="imagePreview" src="{{ isset($users) ? asset($users->image) : '' }}" alt="Image Preview"
                    style="{{ isset($users) && $users->image ? '' : 'display: none;' }}margin-top:10px;max-width: 45%;height:auto;" />
            </div>
        </div>

        <!-- স্বাক্ষর -->
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
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit('সংরক্ষণ করুন', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('users.index') }}" class="btn btn-danger">বাতিল করুন</a>
</div>

