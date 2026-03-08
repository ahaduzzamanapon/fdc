<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Producer;

class UpdateProducerRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Producer::$rules;

        $id = $this->route('producer'); // resource route id

        $rules['phone_number'] = 'required|unique:producers,phone_number,' . $id;
        $rules['email'] = 'required|email|unique:producers,email,' . $id;

        return $rules;
    }
}
