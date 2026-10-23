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
        ];
    }

    /**
     * The card details, named as Pin Payments expects them.
     */
    public function card(): array
    {
        return [
            'number' => $this->input('number'),
            'expiry_month' => $this->input('month'),
            'expiry_year' => $this->input('year'),
            'cvc' => $this->input('cvc'),
        ];
    }
}
