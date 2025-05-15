<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\PersonTitleCheck;
use Illuminate\Validation\Factory as ValidationFactory;
use Request;


class EnquiryStoreRequest extends FormRequest
{
    public function __construct(ValidationFactory $validationFactory)
    {
        // $validationFactory->extend(
        //     'empty_if',
        //     function ($attribute, $value, $parameters) {
        //         if(Request::has($parameters[0]) && Request::get($parameters[0])){
        //             return true;
        //         }else{
        //             return false;
        //         }
        //     },
        //     'The :attribute field have to be empty when :other field is present.'
        // );
    }

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
            'tel' => '',
            'email' => 'required|email',
            'enquiry_type' => 'required|exists:enquiry_types,id',
            'referral' => '',
            'assignedto' => 'required|exists:users,id',
            'note' => 'max:250',
            'country_id'=>'required',

        ];
    }
}
