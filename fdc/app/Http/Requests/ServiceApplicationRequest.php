<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceApplicationRequest extends FormRequest
{

    public function authorize(): bool {
        return true;
    }

    ## For input data rules
    public function rules(): array
    {
        return [
            'category' => 'nullable|string|max:50',
            'film_title' => 'string|max:255',
            'film_serial_no' => 'nullable|string|max:100',
            'production_start_date' => 'nullable|date',
            'budget_amount' => 'nullable|numeric',
            'service_type' => 'nullable|string|max:50',
            'production_type' => 'nullable|string|max:50',
            'film_duration' => 'nullable|integer',

            'set_design' => 'nullable|string|max:255',
            'equipment_rental' => 'nullable|string|max:255',
            'editing' => 'nullable|string|max:255',
            'color_grading' => 'nullable|string|max:255',
            'vfx' => 'nullable|string|max:255',
            'digital_camera' => 'nullable|string|max:255',
            'digital_lab' => 'nullable|string|max:255',

            'approx_cost_general' => 'nullable|numeric',
            'approx_cost_animation' => 'nullable|numeric',
            'approx_cost_shortfilm' => 'nullable|numeric',
            'approx_cost_others' => 'nullable|numeric',

            'film_type' => 'nullable|string|max:255',
            'org_type' => 'nullable|string|max:255',
            'banner_name' => 'nullable|string|max:255',
            'freedom_film_info' => 'nullable|string',
            'previous_films_info' => 'nullable|string',
            'board_member_status' => 'nullable|string|max:255',

            'director_name' => 'nullable|string|max:255',
            'director_nid' => 'nullable|string|max:50',
            'cameraman_name' => 'nullable|string|max:255',
            'main_cast' => 'nullable|string|max:255',
            'foreign_participation' => 'nullable|string|max:255',
            'script_writer_name' => 'nullable|string|max:255',

            'applicant_name' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'permanent_address' => 'nullable|string',
            'present_address' => 'nullable|string',
            'nid_number' => 'nullable|string|max:50',

            'nid_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',

            'phone_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',

            'organization_name' => 'nullable|string|max:255',
            'organization_address' => 'nullable|string|max:500',
            'organization_phone' => 'nullable|string|max:50',
            'organization_email' => 'nullable|email|max:255',
            'bank_account_info' => 'nullable|string|max:500',

            'nominee_name' => 'nullable|string|max:255',
            'nominee_relation' => 'nullable|string|max:255',
        ];
    }


    ## For custom message
    public function messages(): array {
        return [
            'film_title.string' => 'Title must be needed',
            'production_start_date.date' => 'Production start date must be a valid date.',
            'budget_amount.numeric' => 'Budget amount must be a valid number.',
            'film_duration.integer' => 'Film duration must be a valid number.',
            'nid_file.mimes' => 'NID file must be a JPG, JPEG, PNG or PDF file.',
            'nid_file.max' => 'NID file size must not exceed 2MB.',
            'email.email' => 'Please enter a valid email address.',
            'organization_email.email' => 'Please enter a valid organization email address.',
        ];
    }
}
