<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentContactDetailRequest extends FormRequest
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
        return [
            "enquiry_list_id" => "sometimes|exists:enquiry_lists,id",
            "basic_info_id" => "required|exists:basic_infos,id",
            "country_mobile" => "required|exists:basic_infos,id",
            "primary_mobile" => "required",
            "country_contacttwo" => "",
            "contact_number_two" => "",
            "primary_email" => "email"
        ];
    }
}
