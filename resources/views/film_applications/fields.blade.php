<!-- Section: ফিল্ম সংক্রান্ত তথ্য -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">{{ __('messages.film_related_information') }}</legend>
    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="film_title" class="form-label">{{ __('messages.category_label') }}</label>
            <select class="form-select" id="category" name="category" re>
                <option selected>{{ __('messages.select_category_film') }}</option>
                <option value="cinema">সিনেমা </option>
                <option value="adds">{{ __('messages.advertisement') }}</option>

            </select>

        </div>
        <div class="mb-3 col-md-8">
            <label for="film_title" class="form-label">{{ __('messages.name_of_produced_film_advertisement') }}</label>
            <input type="text" class="form-control" id="film_title" name="film_title">
        </div>


        <div class="col-md-4 mb-3">
            <label for="film_serial_no" class="form-label">{{ __('messages.applied_film_number') }}</label>
            <input type="text" class="form-control" id="film_serial_no" name="film_serial_no">
        </div>
        <div class="col-md-4 mb-3">
            <label for="production_start_date" class="form-label">{{ __('messages.production_date') }}</label>
            <input type="date" class="form-control" id="production_start_date" name="production_start_date">
        </div>


        <div class="mb-3 col-md-4">
            <label for="budget_amount" class="form-label">{{ __('messages.budget_allocation_bdt') }}</label>
            <input type="number" class="form-control" id="budget_amount" name="budget_amount">
        </div>

        <div class="mb-3 col-md-4">
            <label for="service_type" class="form-label">{{ __('messages.service_type') }}</label>
            <select class="form-select" id="service_type" name="service_type">
                <option selected disabled>{{ __('messages.select_type') }}</option>
                <option value="general">{{ __('messages.general_facility') }}</option>
                <option value="with_budget">{{ __('messages.cash_price') }}</option>
                <option value="with_camera">{{ __('messages.with_camera') }}</option>
                <option value="except_camera">{{ __('messages.without_camera') }}</option>
                <option value="government_funded">{{ __('messages.government_funded') }}</option>
                <option value="other">অন্যান্য</option>
            </select>
        </div>
        <div class="mb-3 col-md-4">
            <label for="production_type" class="form-label">{{ __('messages.production_type') }}</label>
            <select class="form-select" id="production_type" name="production_type">
                <option selected disabled>{{ __('messages.select_production_type') }}</option>
                <option value="sole_proprietorship">{{ __('messages.sole_proprietorship') }}</option>
                <option value="joint_ownership">{{ __('messages.joint_ownership') }}</option>
                <option value="partnership">{{ __('messages.partnership') }}</option>
                <option value="co_production">{{ __('messages.co_production') }}</option>
                <option value="others">অন্যান্য</option>
            </select>
        </div>
        <div class="mb-3 col-md-4">
            <label for="film_duration" class="form-label">{{ __('messages.film_duration') }}</label>
            <input type="number" class="form-control" id="film_duration" name="film_duration" placeholder="{{ __('messages.enter_duration_in_minutes') }}">
        </div>
    </div>
</fieldset>
<!-- Section: অতিরিক্ত চলচ্চিত্র সংক্রান্ত তথ্য -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">{{ __('messages.additional_film_related_information') }}</legend>

    <div class="row">
        <div class="mb-3 col-md-4">
            <label for="set_design" class="form-label">{{ __('messages.set_design') }}</label>
            <input type="text" class="form-control" id="set_design" name="set_design">
        </div>
        <div class="mb-3 col-md-4">
            <label for="equipment_rental" class="form-label">{{ __('messages.equipment_rental') }}</label>
            <input type="text" class="form-control" id="equipment_rental" name="equipment_rental">
        </div>
        <div class="mb-3 col-md-4">
            <label for="editing" class="form-label">{{ __('messages.editing') }}</label>
            <input type="text" class="form-control" id="editing" name="editing">
        </div>
        <div class="mb-3 col-md-4">
            <label for="color_grading" class="form-label">{{ __('messages.color_grading') }}</label>
            <input type="text" class="form-control" id="color_grading" name="color_grading">
        </div>
        <div class="mb-3 col-md-4">
            <label for="vfx" class="form-label">{{ __('messages.vfx') }}</label>
            <input type="text" class="form-control" id="vfx" name="vfx">
        </div>
        <div class="mb-3 col-md-4">
            <label for="digital_camera" class="form-label">{{ __('messages.digital_camera') }}</label>
            <input type="text" class="form-control" id="digital_camera" name="digital_camera">
        </div>
        <div class="mb-3 col-md-4">
            <label for="digital_lab" class="form-label">{{ __('messages.digital_lab') }}</label>
            <input type="text" class="form-control" id="digital_lab" name="digital_lab">
        </div>
        <div class="mb-3 col-md-4">
            <label for="approx_cost_general" class="form-label">{{ __('messages.estimated_cost_general') }}</label>
            <input type="text" class="form-control" id="approx_cost_general" name="approx_cost_general">
        </div>
        <div class="mb-3 col-md-4">
            <label for="approx_cost_animation" class="form-label">{{ __('messages.estimated_cost_animation') }}</label>
            <input type="text" class="form-control" id="approx_cost_animation" name="approx_cost_animation">
        </div>
        <div class="mb-3 col-md-4">
            <label for="approx_cost_shortfilm" class="form-label">{{ __('messages.estimated_cost_short_film') }}</label>
            <input type="text" class="form-control" id="approx_cost_shortfilm" name="approx_cost_shortfilm">
        </div>
        <div class="mb-3 col-md-4">
            <label for="approx_cost_others" class="form-label">{{ __('messages.estimated_cost_others') }}</label>
            <input type="text" class="form-control" id="approx_cost_others" name="approx_cost_others">
        </div>
        <div class="mb-3 col-md-4">
            <label for="film_type" class="form-label">{{ __('messages.film_type') }}</label>
            <input type="text" class="form-control" id="film_type" name="film_type">
        </div>
        <div class="mb-3 col-md-4">
            <label for="org_type" class="form-label">{{ __('messages.organization_type') }}</label>
            <input type="text" class="form-control" id="org_type" name="org_type">
        </div>
        <div class="mb-3 col-md-4">
            <label for="banner_name" class="form-label">{{ __('messages.banner_name') }}</label>
            <input type="text" class="form-control" id="banner_name" name="banner_name">
        </div>
        <div class="mb-3 col-md-12">
            <label for="freedom_film_info" class="form-label">{{ __('messages.liberation_war_film_info') }}</label>
            <textarea class="form-control" id="freedom_film_info" name="freedom_film_info" rows="2"></textarea>
        </div>
        <div class="mb-3 col-md-12">
            <label for="previous_films_info" class="form-label">{{ __('messages.previous_films_info') }}</label>
            <textarea class="form-control" id="previous_films_info" name="previous_films_info" rows="2"></textarea>
        </div>
        <div class="mb-3 col-md-4">
            <label for="board_member_status" class="form-label">{{ __('messages.board_member_responsibility') }}</label>
            <input type="text" class="form-control" id="board_member_status" name="board_member_status">
        </div>
        <div class="mb-3 col-md-4">
            <label for="director_name" class="form-label">{{ __('messages.director_name') }}</label>
            <input type="text" class="form-control" id="director_name" name="director_name">
        </div>
        <div class="mb-3 col-md-4">
            <label for="director_nid" class="form-label">{{ __('messages.director_nid') }}</label>
            <input type="text" class="form-control" id="director_nid" name="director_nid">
        </div>
        <div class="mb-3 col-md-4">
            <label for="cameraman_name" class="form-label">{{ __('messages.cameraman_name') }}</label>
            <input type="text" class="form-control" id="cameraman_name" name="cameraman_name">
        </div>
        <div class="mb-3 col-md-4">
            <label for="main_cast" class="form-label">{{ __('messages.main_character') }}</label>
            <input type="text" class="form-control" id="main_cast" name="main_cast">
        </div>
        <div class="mb-3 col-md-4">
            <label for="foreign_participation" class="form-label">{{ __('messages.foreign_participation') }}</label>
            <input type="text" class="form-control" id="foreign_participation" name="foreign_participation">
        </div>
        <div class="mb-3 col-md-4">
            <label for="script_writer_name" class="form-label">{{ __('messages.scriptwriter_name') }}</label>
            <input type="text" class="form-control" id="script_writer_name" name="script_writer_name">
        </div>
    </div>
</fieldset>


<!-- Section: আবেদনকারীর তথ্য -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">{{ __('messages.applicant_information') }}</legend>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label for="applicant_name" class="form-label">{{ __('messages.name') }}</label>
            <input type="text" class="form-control" id="applicant_name" name="applicant_name">
        </div>
        <div class="col-md-4 mb-3">
            <label for="father_name" class="form-label">{{ __('messages.father_name') }}</label>
            <input type="text" class="form-control" id="father_name" name="father_name">
        </div>
        <div class="col-md-4 mb-3">
            <label for="mother_name" class="form-label">{{ __('messages.mother_name') }}</label>
            <input type="text" class="form-control" id="mother_name" name="mother_name">
        </div>
    </div>

    <div class="mb-3">
        <label for="permanent_address" class="form-label">{{ __('messages.permanent_address') }}</label>
        <textarea class="form-control" id="permanent_address" name="permanent_address" rows="2"></textarea>
    </div>

    <div class="mb-3">
        <label for="present_address" class="form-label">{{ __('messages.present_address') }}</label>
        <textarea class="form-control" id="present_address" name="present_address" rows="2"></textarea>
    </div>

    <div class="row">
        <div class="col-md-3 mb-3">
            <label for="nid_number" class="form-label">{{ __('messages.national_id_card_no') }}</label>
            <input type="text" class="form-control" id="nid_number" name="nid_number">
        </div>
        <div class="col-md-3 mb-3">
            <label for="nid_number" class="form-label">{{ __('messages.national_id_card_copy') }}</label>
            <input type="file" class="form-control" id="nid_file" name="nid_file">
        </div>
        <div class="col-md-3 mb-3">
            <label for="phone_number" class="form-label">{{ __('messages.phone_number') }}</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number">
        </div>
        <div class="col-md-3 mb-3">
            <label for="email" class="form-label">{{ __('messages.email') }}</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
    </div>
</fieldset>

<!-- Section: প্রতিষ্ঠান ও ব্যাংক -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">{{ __('messages.organization_bank_information') }}</legend>

    <div class="mb-3">
        <label for="organization_name" class="form-label">{{ __('messages.organization_name') }}</label>
        <input type="text" class="form-control" id="organization_name" name="organization_name">
    </div>

    <div class="mb-3">
        <label for="organization_address" class="form-label">{{ __('messages.contact_address') }}</label>
        <textarea class="form-control" id="organization_address" name="organization_address" rows="2"></textarea>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="organization_phone" class="form-label">{{ __('messages.phone_number') }}</label>
            <input type="text" class="form-control" id="organization_phone" name="organization_phone">
        </div>
        <div class="col-md-6 mb-3">
            <label for="organization_email" class="form-label">{{ __('messages.email') }}</label>
            <input type="email" class="form-control" id="organization_email" name="organization_email">
        </div>
    </div>

    <div class="mb-3">
        <label for="bank_account_info" class="form-label">{{ __('messages.bank_account_info_and_name') }}</label>
        <textarea class="form-control" id="bank_account_info" name="bank_account_info" rows="2"></textarea>
    </div>
</fieldset>

<!-- Section: নমিনি -->
<fieldset class="border p-3 mb-4">
    <legend class="float-none w-auto px-2">{{ __('messages.nominee_info') }}</legend>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="nominee_name" class="form-label">{{ __('messages.nominee_name_label') }}</label>
            <input type="text" class="form-control" id="nominee_name" name="nominee_name">
        </div>
        <div class="col-md-6 mb-3">
            <label for="nominee_relation" class="form-label">{{ __('messages.relationship_with_applicant') }}</label>
            <input type="text" class="form-control" id="nominee_relation" name="nominee_relation">
        </div>
    </div>
</fieldset>


<!-- Submit Field -->
<div class="form-group col-sm-12" style="text-align-last: right;">
    {!! Form::submit(__('messages.save'), ['class' => 'btn btn-primary']) !!}
    <a href="{{ route('filmApplications.index') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>
</div>
