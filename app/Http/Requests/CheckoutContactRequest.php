<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutContactRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => ['required', 'regex:/^(?:\+?(61))? ?(?:\((?=.*\)))?(0?[2-57-8])\)? ?(\d\d(?:[- ](?=\d{3})|(?!\d\d[- ]?\d[- ]))\d\d[- ]?\d[- ]?\d{3})$/'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field can not be blank.',
            'phone.regex' => 'The phone number must be a valid Australian number. eg 03 7010 1234 or 0491 570 006',
        ];
    }
}
