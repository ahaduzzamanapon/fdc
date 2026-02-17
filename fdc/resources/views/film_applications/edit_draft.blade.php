@extends('layouts.default')
@section('title')
    Film Application {{ __('messages.film_application') }} @parent
@stop
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('adminlte-templates::common.errors')
                    <form action="{{ route('filmApplications.film.update.draft') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                        <input type="hidden" name="film_id" value="{{ $film->id }}">
                        {{--সিনেমা সংক্রান্ত তথ্য--}}
                        <fieldset class="border p-3 mb-4">
                            <legend class="float-none w-auto px-2">{{ __('messages.film_related_information') }}</legend>
                            <div class="row">
                                <input type="hidden" name="category" value="{{ old('category', $film->category) }}">
                                <div class="mb-3 col-md-8">
                                    <label class="form-label">{{ __('messages.name_of_produced_film_advertisement') }}</label>
                                    <input type="text" class="form-control" name="film_title" value="{{ old('film_title', $film->film_title) }}">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">{{ __('messages.applied_film_number') }}</label>
                                    <input type="text" class="form-control" name="film_serial_no" value="{{ old('film_serial_no', $film->film_serial_no) }}">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">{{ __('messages.production_date') }}</label>
                                    <input type="date" class="form-control" name="production_start_date" value="{{ old('production_start_date', $film->production_start_date) }}">
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label class="form-label">{{ __('messages.budget_allocation_bdt') }}</label>
                                    <input type="number" class="form-control" name="budget_amount" value="{{ old('budget_amount', $film->budget_amount) }}">
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label class="form-label">{{ __('messages.service_type') }}</label>
                                    @php
                                        $serviceTypes = [
                                            'general' => 'general_facility',
                                            'with_budget' => 'cash_price',
                                            'with_camera' => 'with_camera',
                                            'except_camera' => 'without_camera',
                                            'government_funded' => 'government_funded',
                                            'other' => null
                                        ];
                                    @endphp

                                    <select class="form-select" name="service_type">
                                        <option disabled>{{ __('messages.select_type') }}</option>
                                        @foreach($serviceTypes as $value => $labelKey)
                                            <option value="{{ $value }}"
                                                {{ old('service_type', $film->service_type) == $value ? 'selected' : '' }}>
                                                {{ $labelKey ? __('messages.'.$labelKey) : 'অন্যান্য' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label class="form-label">{{ __('messages.production_type') }}</label>
                                    <select class="form-select" name="production_type">
                                        @foreach(['sole_proprietorship','joint_ownership','partnership','co_production','others'] as $ptype)
                                            <option value="{{ $ptype }}"
                                                {{ old('production_type', $film->production_type) == $ptype ? 'selected' : '' }}>
                                                {{ __('messages.'.$ptype) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 col-md-4">
                                    <label class="form-label">{{ __('messages.film_duration') }}</label>
                                    <input type="number" class="form-control" name="film_duration" value="{{ old('film_duration', $film->film_duration) }}">
                                </div>
                            </div>
                        </fieldset>

                        {{--অতিরিক্ত চলচ্চিত্র সংক্রান্ত তথ্য--}}
                        <fieldset class="border p-3 mb-4">
                            <legend class="float-none w-auto px-2">
                                {{ __('messages.additional_film_related_information') }}
                            </legend>

                            <div class="row">

                                @php
                                    $fields = [
                                        'set_design' => 'set_design',
                                        'equipment_rental' => 'equipment_rental',
                                        'editing' => 'editing',
                                        'color_grading' => 'color_grading',
                                        'vfx' => 'vfx',
                                        'digital_camera' => 'digital_camera',
                                        'digital_lab' => 'digital_lab',
                                        'approx_cost_general' => 'estimated_cost_general',
                                        'approx_cost_animation' => 'estimated_cost_animation',
                                        'approx_cost_shortfilm' => 'estimated_cost_short_film',
                                        'approx_cost_others' => 'estimated_cost_others',
                                        'film_type' => 'film_type',
                                        'org_type' => 'organization_type',
                                        'banner_name' => 'banner_name',
                                        'board_member_status' => 'board_member_responsibility',
                                        'director_name' => 'director_name',
                                        'director_nid' => 'director_nid',
                                        'cameraman_name' => 'cameraman_name',
                                        'main_cast' => 'main_character',
                                        'foreign_participation' => 'foreign_participation',
                                        'script_writer_name' => 'scriptwriter_name',
                                    ];
                                @endphp

                                @foreach($fields as $field => $labelKey)
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">
                                            {{ __('messages.'.$labelKey) }}
                                        </label>
                                        <input type="text" class="form-control" name="{{ $field }}" value="{{ old($field, $film->$field) }}">
                                    </div>
                                @endforeach

                                <div class="mb-3 col-md-12">
                                    <label class="form-label">
                                        {{ __('messages.liberation_war_film_info') }}
                                    </label>
                                    <textarea class="form-control" name="freedom_film_info" rows="2">{{ old('freedom_film_info', $film->freedom_film_info) }}</textarea>
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label class="form-label">
                                        {{ __('messages.previous_films_info') }}
                                    </label>
                                    <textarea class="form-control" name="previous_films_info" rows="2">{{ old('previous_films_info', $film->previous_films_info) }}</textarea>
                                </div>

                            </div>
                        </fieldset>

                        {{--আবেদনকারীর তথ্য--}}
                        <fieldset class="border p-3 mb-4">
                            <legend class="float-none w-auto px-2">
                                {{ __('messages.applicant_information') }}
                            </legend>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="applicant_name" class="form-label">
                                        {{ __('messages.name') }}
                                    </label>
                                    <input type="text" class="form-control" id="applicant_name" name="applicant_name" value="{{ old('applicant_name', $film->applicant_name ?? '') }}">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="father_name" class="form-label">
                                        {{ __('messages.father_name') }}
                                    </label>
                                    <input type="text" class="form-control" id="father_name" name="father_name" value="{{ old('father_name', $film->father_name ?? '') }}">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="mother_name" class="form-label">
                                        {{ __('messages.mother_name') }}
                                    </label>
                                    <input type="text" class="form-control" id="mother_name" name="mother_name" value="{{ old('mother_name', $film->mother_name ?? '') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="permanent_address" class="form-label">
                                    {{ __('messages.permanent_address') }}
                                </label>
                                <textarea class="form-control" id="permanent_address" name="permanent_address" rows="2">{{ old('permanent_address', $film->permanent_address ?? '') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="present_address" class="form-label">
                                    {{ __('messages.present_address') }}
                                </label>
                                <textarea class="form-control" id="present_address" name="present_address" rows="2">{{ old('present_address', $film->present_address ?? '') }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nid_number" class="form-label">
                                        {{ __('messages.national_id_card_no') }}
                                    </label>
                                    <input type="text" class="form-control" id="nid_number" name="nid_number" value="{{ old('nid_number', $film->nid_number ?? '') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="nid_file" class="form-label">
                                        {{ __('messages.national_id_card_copy') }}
                                    </label>

                                    <input type="file" class="form-control" id="nid_file" name="nid_file" accept=".jpg,.jpeg,.png,.pdf">

                                    {{--Preview Container--}}
                                    <div class="mt-3" id="nid_preview_container">
                                        @if(!empty($film->nid_file))
                                            @php
                                                $fileUrl = asset($film->nid_file);
                                                $extension = strtolower(pathinfo($film->nid_file, PATHINFO_EXTENSION));
                                            @endphp

                                            {{--Image Preview--}}
                                            @if(in_array($extension, ['jpg','jpeg','png']))
                                                <img src="{{ $fileUrl }}" alt="NID Preview" class="img-fluid border rounded" style="max-height:250px;">
                                            @endif

                                            {{--PDF Preview--}}
                                            @if($extension === 'pdf')
                                                <iframe src="{{ $fileUrl }}" width="100%" height="300" class="border rounded"></iframe>
                                            @endif
                                        @endif
                                    </div>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="phone_number" class="form-label">
                                        {{ __('messages.phone_number') }}
                                    </label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $film->phone_number ?? '') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        {{ __('messages.email') }}
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $film->email ?? '') }}">
                                </div>
                            </div>
                        </fieldset>

                        {{--্রতিষ্ঠান ও ব্যাংক তথ্য--}}
                        <fieldset class="border p-3 mb-4">
                            <legend class="float-none w-auto px-2">{{ __('messages.organization_bank_information') }}</legend>

                            <div class="mb-3">
                                <label for="organization_name" class="form-label">{{ __('messages.organization_name') }}</label>
                                <input type="text" class="form-control" id="organization_name" name="organization_name" value="{{ old('organization_name', $film->organization_name) }}">
                            </div>

                            <div class="mb-3">
                                <label for="organization_address" class="form-label">{{ __('messages.contact_address') }}</label>
                                <textarea class="form-control" id="organization_address" name="organization_address" rows="2">{{ old('organization_address', $film->organization_address) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="organization_phone" class="form-label">{{ __('messages.phone_number') }}</label>
                                    <input type="text" class="form-control" id="organization_phone" name="organization_phone" value="{{ old('organization_phone', $film->organization_phone) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="organization_email" class="form-label">{{ __('messages.email') }}</label>
                                    <input type="email" class="form-control" id="organization_email" name="organization_email" value="{{ old('organization_email', $film->organization_email) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="bank_account_info" class="form-label">{{ __('messages.bank_account_info_and_name') }}</label>
                                <textarea class="form-control" id="bank_account_info" name="bank_account_info" rows="2">{{ old('bank_account_info', $film->bank_account_info) }}</textarea>
                            </div>
                        </fieldset>

                        {{--নমিনি তথ্য--}}
                        <fieldset class="border p-3 mb-4">
                            <legend class="float-none w-auto px-2">{{ __('messages.nominee_info') }}</legend>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nominee_name" class="form-label">{{ __('messages.nominee_name_label') }}</label>
                                    <input type="text" class="form-control" id="nominee_name" name="nominee_name" value="{{ old('nominee_name', $film->nominee_name) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="nominee_relation" class="form-label">{{ __('messages.relationship_with_applicant') }}</label>
                                    <input type="text" class="form-control" id="nominee_relation" name="nominee_relation" value="{{ old('nominee_relation', $film->nominee_relation) }}">
                                </div>
                            </div>
                        </fieldset>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
                            <a href="{{ route('filmApplications.index') }}" class="btn btn-danger">{{ __('messages.cancel') }}</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const fileInput = document.getElementById('nid_file');
            if (!fileInput) return; // safety check

            fileInput.addEventListener('change', function(event) {

                const previewContainer = document.getElementById('nid_preview_container');
                if (!previewContainer) return;

                previewContainer.innerHTML = '';

                const file = event.target.files[0];
                if (!file) return;

                const fileType = file.type;

                if (fileType.startsWith('image/')) {
                    const img = document.createElement('img');
                    img.src = URL.createObjectURL(file);
                    img.classList.add('img-fluid','border','rounded');
                    img.style.maxHeight = '250px';
                    previewContainer.appendChild(img);
                }
                else if (fileType === 'application/pdf') {
                    const iframe = document.createElement('iframe');
                    iframe.src = URL.createObjectURL(file);
                    iframe.width = '100%';
                    iframe.height = '300';
                    iframe.classList.add('border','rounded');
                    previewContainer.appendChild(iframe);
                }
            });
        });
    </script>

@endsection



