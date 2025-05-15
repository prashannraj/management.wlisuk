<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PersonTitleCheck;
use Illuminate\Validation\Factory as ValidationFactory;
use Request;


class EnquiryUpdateRequest extends FormRequest
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
            'title' => ['required', new PersonTitleCheck()],
            'surname' => 'required|min:2',
            'firstName' => 'required|min:3|max:25',
            'middleName' => 'max:25',
            'mobile_code' => 'required_with:mobile|nullable',
            'mobile' => 'required',
            'tel_code' => 'required_with:tel|nullable',
            'tel' => 'nullable',
            'email' => 'required|email',
            'enquiry_type' => 'required|exists:enquiry_types,id',
            'referral' => '',
            'country_id'=>'required',
            'assignedto' => 'required|exists:users,id',
            'note' => 'nullable',
            'status'=>'required'
        ];
    }
}
