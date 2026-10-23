<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardExpirationMonth;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardNumber;

class CheckoutCardRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Pin needs at least two words, e.g. 'John Smith'
            'name' => ['required', 'regex:/\S+\s+\S+/'],
            'number' => ['required', new CardNumber],
            'year' => ['required', new CardExpirationYear($this->input('month'))],
            'month' => ['required', new CardExpirationMonth($this->input('year'))],
            'cvc' => ['required', new CardCvc($this->input('number'))],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'The :attribute field can not be blank.',
            'name.regex' => 'Please enter the name as it appears on the card, including the surname.',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'name on card',
        ];
    }

    /**
     * The card details, named as Pin Payments expects them.
     */
    public function card(): array
    {
        return [
            'name' => $this->input('name'),
            'number' => $this->input('number'),
            'expiry_month' => $this->input('month'),
            'expiry_year' => $this->input('year'),
            'cvc' => $this->input('cvc'),
        ];
    }
}
