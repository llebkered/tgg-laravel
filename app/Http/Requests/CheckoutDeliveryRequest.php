<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutDeliveryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'line1' => 'required',
            'line2' => '',
            'postcode' => ['required', 'size:4', 'regex:/[2-5]\d\d\d|[0][2,7,8,9]\d\d/'], // 2-5NNN. 0[2,8,09]NN ie not WA or Tas
            'city' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field can not be blank.',
            'postcode.size' => 'The post code must be a 4 digit number (WA and Tas not accepted.)',
            'postcode.regex' => 'Please check your postcode is correct. (WA and Tas not accepted.)',
        ];
    }
}
