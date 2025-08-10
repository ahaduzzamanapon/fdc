<!-- Section: ফিল্ম সংক্রান্ত তথ্য -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">ফিল্ম সংক্রান্ত তথ্য</legend>
    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="film_title" class="form-label">ক্যাটাগরিঃ</label>
            <select class="form-select" id="category" name="category" re>
                <option selected>ক্যাটাগরি নির্বাচন করুন</option>
                <option value="cinema">ছিনেমা</option>
                <option value="adds">বিজ্ঞাপন</option>

            </select>

        </div>
        <div class="mb-3 col-md-8">
            <label for="film_title" class="form-label">প্রযোজিত ছবি/বিজ্ঞাপন চিত্রের নাম</label>
            <input type="text" class="form-control" id="film_title" name="film_title">
        </div>


        <div class="col-md-4 mb-3">
            <label for="film_serial_no" class="form-label">আবেদনকৃত চলচ্চিত্রের নম্বর</label>
            <input type="text" class="form-control" id="film_serial_no" name="film_serial_no">
        </div>
        <div class="col-md-4 mb-3">
            <label for="production_start_date" class="form-label">প্রযোজনার তারিখ</label>
            <input type="date" class="form-control" id="production_start_date" name="production_start_date">
        </div>


        <div class="mb-3 col-md-4">
            <label for="budget_amount" class="form-label">বাজেট নির্ধারণ (টাকা)</label>
            <input type="number" class="form-control" id="budget_amount" name="budget_amount">
        </div>

        <div class="mb-3 col-md-4">
            <label for="service_type" class="form-label">সেবার ধরন</label>
            <select class="form-select" id="service_type" name="service_type">
                <option selected disabled>ধরণ নির্বাচন করুন</option>
                <option value="general">সাধারণ সুবিধা</option>
                <option value="with_budget">নগদ মূল্যে</option>
                <option value="with_camera">ক্যামেরা সহ</option>
                <option value="except_camera">ক্যামেরা ব্যতীত</option>
                <option value="government_funded">সরকারী অনুদানে নির্মিত</option>
                <option value="other">অন্যান্য</option>
            </select>
        </div>
        <div class="mb-3 col-md-4">
            <label for="production_type" class="form-label">প্রযোজনার ধরন</label>
            <select class="form-select" id="production_type" name="production_type">
                <option selected disabled>প্রযোজনার ধরন নির্বাচন করুন</option>
                <option value="sole_proprietorship">একক মালিকানা</option>
                <option value="joint_ownership">যৌথ মালিকানা</option>
                <option value="partnership">অংশিদারিত্ত</option>
                <option value="co_production">যৌথ প্রযোজনা</option>
                <option value="others">অন্যান্য</option>
            </select>
        </div>
        <div class="mb-3 col-md-4">
            <label for="film_duration" class="form-label">চলচ্চিত্রের সময়কাল (মাস)</label>
            <input type="number" class="form-control" id="film_duration" name="film_duration" placeholder="মিনিটে সময়কাল লিখুন">
        </div>
    </div>
</fieldset>
<!-- Section: অতিরিক্ত চলচ্চিত্র সংক্রান্ত তথ্য -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">অতিরিক্ত চলচ্চিত্র সংক্রান্ত তথ্য</legend>

    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="set_design" class="form-label">সেট ডিজাইন</label>
            <input type="text" class="form-control" id="set_design" name="set_design">
        </div>
        <div class="mb-3 col-md-4">
            <label for="equipment_rental" class="form-label">ইকুইপমেন্ট ভাড়া</label>
            <input type="text" class="form-control" id="equipment_rental" name="equipment_rental">
        </div>
        <div class="mb-3 col-md-4">
            <label for="editing" class="form-label">এডিটিং</label>
            <input type="text" class="form-control" id="editing" name="editing">
        </div>
        <div class="mb-3 col-md-4">
            <label for="color_grading" class="form-label">কালার গ্রেডিং</label>
            <input type="text" class="form-control" id="color_grading" name="color_grading">
        </div>
        <div class="mb-3 col-md-4">
            <label for="vfx" class="form-label">VFX</label>
            <input type="text" class="form-control" id="vfx" name="vfx">
        </div>
        <div class="mb-3 col-md-4">
            <label for="digital_camera" class="form-label">ডিজিটাল ক্যামেরা</label>
            <input type="text" class="form-control" id="digital_camera" name="digital_camera">
        </div>
        <div class="mb-3 col-md-4">
            <label for="digital_lab" class="form-label">ডিজিটাল ল্যাব</label>
            <input type="text" class="form-control" id="digital_lab" name="digital_lab">
        </div>
        <div class="mb-3 col-md-4">
            <label for="approx_cost_general" class="form-label">আনুমানিক খরচ (সাধারণ)</label>
            <input type="text" class="form-control" id="approx_cost_general" name="approx_cost_general">
        </div>
        <div class="mb-3 col-md-4">
            <label for="approx_cost_animation" class="form-label">আনুমানিক খরচ (অ্যানিমেশন)</label>
            <input type="text" class="form-control" id="approx_cost_animation" name="approx_cost_animation">
        </div>
        <div class="mb-3 col-md-4">
            <label for="approx_cost_shortfilm" class="form-label">আনুমানিক খরচ (শর্ট ফিল্ম)</label>
            <input type="text" class="form-control" id="approx_cost_shortfilm" name="approx_cost_shortfilm">
        </div>
        <div class="mb-3 col-md-4">
            <label for="approx_cost_others" class="form-label">আনুমানিক খরচ (অন্যান্য)</label>
            <input type="text" class="form-control" id="approx_cost_others" name="approx_cost_others">
        </div>
        <div class="mb-3 col-md-4">
            <label for="film_type" class="form-label">চলচ্চিত্রের ধরন</label>
            <input type="text" class="form-control" id="film_type" name="film_type">
        </div>
        <div class="mb-3 col-md-4">
            <label for="org_type" class="form-label">প্রতিষ্ঠানের ধরন</label>
            <input type="text" class="form-control" id="org_type" name="org_type">
        </div>
        <div class="mb-3 col-md-4">
            <label for="banner_name" class="form-label">ব্যানারের নাম</label>
            <input type="text" class="form-control" id="banner_name" name="banner_name">
        </div>
        <div class="mb-3 col-md-12">
            <label for="freedom_film_info" class="form-label">মুক্তিযুদ্ধ বিষয়ক চলচ্চিত্র হলে বিস্তারিত তথ্য</label>
            <textarea class="form-control" id="freedom_film_info" name="freedom_film_info" rows="2"></textarea>
        </div>
        <div class="mb-3 col-md-12">
            <label for="previous_films_info" class="form-label">পূর্বে নির্মিত চলচ্চিত্র সম্পর্কিত তথ্য</label>
            <textarea class="form-control" id="previous_films_info" name="previous_films_info" rows="2"></textarea>
        </div>
        <div class="mb-3 col-md-4">
            <label for="board_member_status" class="form-label">বোর্ড সদস্য হিসেবে দায়িত্ব</label>
            <input type="text" class="form-control" id="board_member_status" name="board_member_status">
        </div>
        <div class="mb-3 col-md-4">
            <label for="director_name" class="form-label">পরিচালকের নাম</label>
            <input type="text" class="form-control" id="director_name" name="director_name">
        </div>
        <div class="mb-3 col-md-4">
            <label for="director_nid" class="form-label">পরিচালকের NID</label>
            <input type="text" class="form-control" id="director_nid" name="director_nid">
        </div>
        <div class="mb-3 col-md-4">
            <label for="cameraman_name" class="form-label">চিত্রগ্রাহকের নাম</label>
            <input type="text" class="form-control" id="cameraman_name" name="cameraman_name">
        </div>
        <div class="mb-3 col-md-4">
            <label for="main_cast" class="form-label">প্রধান চরিত্র</label>
            <input type="text" class="form-control" id="main_cast" name="main_cast">
        </div>
        <div class="mb-3 col-md-4">
            <label for="foreign_participation" class="form-label">বিদেশি অংশগ্রহণ থাকলে</label>
            <input type="text" class="form-control" id="foreign_participation" name="foreign_participation">
        </div>
        <div class="mb-3 col-md-4">
            <label for="script_writer_name" class="form-label">চিত্রনাট্যকারের নাম</label>
            <input type="text" class="form-control" id="script_writer_name" name="script_writer_name">
        </div>
    </div>
</fieldset>


<!-- Section: আবেদনকারীর তথ্য -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">আবেদনকারীর তথ্য</legend>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="applicant_name" class="form-label">নাম</label>
            <input type="text" class="form-control" id="applicant_name" name="applicant_name">
        </div>
        <div class="col-md-4 mb-3">
            <label for="father_name" class="form-label">পিতার নাম</label>
            <input type="text" class="form-control" id="father_name" name="father_name">
        </div>
        <div class="col-md-4 mb-3">
            <label for="mother_name" class="form-label">মাতার নাম</label>
            <input type="text" class="form-control" id="mother_name" name="mother_name">
        </div>
    </div>

    <div class="mb-3">
        <label for="permanent_address" class="form-label">স্থায়ী ঠিকানা</label>
        <textarea class="form-control" id="permanent_address" name="permanent_address" rows="2"></textarea>
    </div>

    <div class="mb-3">
        <label for="present_address" class="form-label">বর্তমান ঠিকানা</label>
        <textarea class="form-control" id="present_address" name="present_address" rows="2"></textarea>
    </div>

    <div class="row">
        <div class="col-md-3 mb-3">
            <label for="nid_number" class="form-label">জাতীয় পরিচয় পত্র নং</label>
            <input type="text" class="form-control" id="nid_number" name="nid_number">
        </div>
        <div class="col-md-3 mb-3">
            <label for="nid_number" class="form-label">জাতীয় পরিচয় পত্র কপি</label>
            <input type="file" class="form-control" id="nid_file" name="nid_file">
        </div>
        <div class="col-md-3 mb-3">
            <label for="phone_number" class="form-label">ফোন নম্বর</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number">
        </div>
        <div class="col-md-3 mb-3">
            <label for="email" class="form-label">ই-মেইল</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
    </div>
</fieldset>

<!-- Section: প্রতিষ্ঠান ও ব্যাংক -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">প্রতিষ্ঠান ও ব্যাংক তথ্য</legend>

    <div class="mb-3">
        <label for="organization_name" class="form-label">প্রতিষ্ঠানের নাম</label>
        <input type="text" class="form-control" id="organization_name" name="organization_name">
    </div>

    <div class="mb-3">
        <label for="organization_address" class="form-label">যোগাযোগের ঠিকানা</label>
        <textarea class="form-control" id="organization_address" name="organization_address" rows="2"></textarea>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="organization_phone" class="form-label">ফোন নম্বর</label>
            <input type="text" class="form-control" id="organization_phone" name="organization_phone">
        </div>
        <div class="col-md-6 mb-3">
            <label for="organization_email" class="form-label">ই-মেইল</label>
            <input type="email" class="form-control" id="organization_email" name="organization_email">
        </div>
    </div>

    <div class="mb-3">
        <label for="bank_account_info" class="form-label">ব্যাংক হিসাব সংক্রান্ত তথ্য ও ব্যাংকের নাম</label>
        <textarea class="form-control" id="bank_account_info" name="bank_account_info" rows="2"></textarea>
    </div>
</fieldset>

<!-- Section: নমিনি -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">নমিনি তথ্য</legend>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nominee_name" class="form-label">নমিনির নাম</label>
            <input type="text" class="form-control" id="nominee_name" name="nominee_name">
        </div>
        <div class="col-md-6 mb-3">
            <label for="nominee_relation" class="form-label">আবেদনকারীর সাথে সম্পর্ক</label>
            <input type="text" class="form-control" id="nominee_relation" name="nominee_relation">
        </div>
    </div>
</fieldset>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('filmApplications.index') }}" class="btn btn-danger">Cancel</a>
</div>
