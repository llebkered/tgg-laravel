<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Order;
use App\Mail\OrderPaid;
use App\Models\Address;
use App\Models\Customer;
use App\Mail\OrderInvoice;
use Illuminate\Http\Request;
use App\Libraries\Pin\PinPayments;
use LVR\CreditCard\CardCvc;
use LVR\CreditCard\CardNumber;
use LVR\CreditCard\CardExpirationYear;
use LVR\CreditCard\CardExpirationMonth;
// use Barryvdh\DomPDF\Facade\Pdf;
use PDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Variation;

use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', '=', 'checkout')->firstOrFail();

        return view('checkout.index')->with(['page' => $page]);
    }

    public function contact(Request $request)
    {
        $page = Page::where('slug', '=', 'checkout')->first();

        // validate
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => ['required', 'regex:/^(?:\+?(61))? ?(?:\((?=.*\)))?(0?[2-57-8])\)? ?(\d\d(?:[- ](?=\d{3})|(?!\d\d[- ]?\d[- ]))\d\d[- ]?\d[- ]?\d{3})$/']
        ];

        $customMessages = [
            'required' => 'The :attribute field can not be blank.',
            'phone.regex' => 'The phone number must be a valid Australian number. eg 03 7010 1234 or 0491 570 006'
        ];

        $data = $this->validate($request, $rules, $customMessages);

        // create customer
        $customer = Customer::create($data);

        // Store in session
        $customerId = $request->session()->put('customer', $customer->id);

        // Create Order
        // $orderDetails['customer_id']  = $request->session()->get('customer');
        $orderDetails['order_status_id'] = 1;
        $orderDetails['cart'] = json_encode(Cart::instance('cart')->content());
        $orderDetails['tax'] = Cart::instance('cart')->tax();
        $orderDetails['gst'] = number_format(str_replace(',', '', Cart::instance('cart')->total()) / 10, 2); //(float)Cart::total() / 10;
        $orderDetails['total'] = Cart::instance('cart')->total();
        $orderDetails['name'] = $request->post('name');
        $orderDetails['email'] = $request->post('email');
        $orderDetails['phone'] = $request->post('phone');

        $order = Order::create($orderDetails);
        // Store order Id in session
        $request->session()->put('order', $order->id);

        // Add customer info to order.
        $order->customer()->associate($customer);
        $order->save();

        //Todo ?? Email order to tgg

        return redirect()->route('checkout.delivery')->with(['page' => $page]);
    }

    public function delivery()
    {
        $page = Page::where('slug', '=', 'checkout')->firstOrFail();
        return view('checkout.delivery')->with(['page' => $page]);
    }

    public function deliverypost(Request $request)
    {
        $page = Page::where('slug', '=', 'checkout')->first();

        $rules = [
            'line1' => 'required',
            'line2' => '',
            'postcode' => ['required', 'size:4', 'regex:/[2-5]\d\d\d|[0][2,7,8,9]\d\d/'], // 2-5NNN. 0[2,8,09]NN ie not WA or Tas
            'city' => 'required'
        ];

        $customMessages = [
            'required' => 'The :attribute field can not be blank.',
            'postcode.size' => 'The post code must be a 4 digit number (WA and Tas not accepted.)',
            'postcode.regex' => 'Please check your postcode is correct. (WA and Tas not accepted.)'
        ];

        $this->validate($request, $rules, $customMessages);

        $data = $request->only('line1', 'line2', 'postcode', 'city', 'state', 'country');

        $order = Order::where('id', '=', $request->session()->get('order'))->first();

        // save address to order
        $order->update($data);



        // $data['customer_id'] = $order->customer_id;

        // $address = Address::create($data);

        // Add address to order
        // $order->address()->associate($address);

        return redirect()->route('checkout.card')->with(['page' => $page]);
    }


    public function card(Request $request)
    {
        $page = Page::where('slug', '=', 'checkout')->firstOrFail();

        $customer = Customer::where('id', '=', $request->session()->get('customer'))->first();

        // Already paid (e.g. back button after paying)
        $order = Order::where('id', '=', $request->session()->get('order'))->first();
        if ($order && $order->order_status_id == 3) {
            return redirect()->route('checkout.thankyou');
        }

        $year = date('Y');
        return view('checkout.card', compact(['year', 'customer']))->with(['page' => $page]);
    }


    // public function processcard(Request $request)
    // {
    //     $page = Page::where('slug', '=', 'checkout')->first();

    //     // dd($request->all());

    //     // validate
    //     // $rules = [
    //     //     'number' => ['required'],
    //     //     'cvc' => ['required']
    //     // ];
    //     // $rules = [
    //     //     'number' => ['required', new CardNumber],
    //     //     'year' => ['required', new CardExpirationYear($this->get('expiration_month'))],
    //     //     'month' => ['required', new CardExpirationMonth($this->get('expiration_year'))],
    //     //     'cvc' => ['required', new CardCvc($this->get('card_number'))]
    //     // ];
    //     $rules = [
    //         'number' => ['required', new CardNumber],
    //         'cvc' => ['required']
    //     ];

    //     $customMessages = [
    //         'required' => 'The :attribute field can not be blank.'
    //     ];

    //     $this->validate($request, $rules, $customMessages);

    //     $order = Order::where('id', '=', $request->session()->get('order'))->first();

    //     $charge = [
    //         "card" =>
    //         [
    //             "number" => $request->post('number'),
    //             "expiry_month"  => $request->post('month'),
    //             "expiry_year"  => $request->post('year'),
    //             "cvc"  => $request->post('cvc'),
    //             "name"  => $order->name,
    //             "address_line1"  => $order->line1,
    //             "address_line2" => $order->line2,
    //             "address_city"  => $order->city,
    //             "address_postcode"  => $order->postcode,
    //             "address_state"  => $order->state,
    //             "address_country"  => "Australia"
    //         ],
    //         "description"  => $this->getDescription(),
    //         "amount" => (int) round($order->total * 100),
    //         "email" => $order->email
    //     ];

    //     $pinPayments = new PinPayments();
    //     $result = $pinPayments->charge($charge);

    //     // Handle errors
    //     // 202 - Card Declined
    //     // 400 - Card Payment Errors
    //     // 401 - Authentication Errors
    //     // 403 - Forbidden
    //     // 404 - Not Found
    //     // 422 - Invalid resource errors
    //     // 502 - Pin Payments Errors
    //     if (in_array($result->getStatusCode(), [202, 400, 401, 403, 404, 422, 502])) {
    //         die($result->getBody());
    //         $errorMsg = json_decode($result->getBody());
    //         $error = $errorMsg->error_description;
    //         return redirect()->route('checkout.card', compact('page'))->with('danger_message', $error)->withInput();
    //     }

    //     if ($result->getStatusCode() == 201) {
    //         // payment success
    //         // update order status to paid
    //         $order->order_status_id = '3';
    //         $order->save();

    //         return redirect()->route('checkout.thankyou', compact('page'))->with('success_message', 'Your payment has been successful.');
    //     } else {
    //         //payment didn't work
    //         $error = json_decode($result->getBody())->messages[0]->message;

    //         return redirect()->route('checkout.card', compact('page'))->with('danger_message', $error);
    //     }
    // }

    public function processcard(Request $request)
    {
        // validate
        $rules = [
            'number' => ['required', new CardNumber],
            'year' => ['required', new CardExpirationYear($request->get('month'))],
            'month' => ['required', new CardExpirationMonth($request->get('year'))],
            'cvc' => ['required', new CardCvc($request->get('number'))]
        ];

        $customMessages = [
            'required' => 'The :attribute field can not be blank.'
        ];

        $this->validate($request, $rules, $customMessages);

        $order = Order::where('id', '=', $request->session()->get('order'))->first();

        // Don't proceed if order is null
        if (is_null($order)) {
            return redirect('/cart');
        }

        // Already paid (e.g. back button or a resubmitted form)
        if ($order->order_status_id == 3) {
            return redirect()->route('checkout.thankyou');
        }

        // Claim the order so only one request can charge it. The update is
        // atomic, so a double click or resubmit finds the order already claimed.
        $claimed = Order::where('id', '=', $order->id)
            ->where('order_status_id', '!=', 3)
            ->whereNull('payment_started_at')
            ->update(['payment_started_at' => now()]);

        if (! $claimed) {
            return redirect()->route('checkout.card')->with('danger_message', 'A payment for this order is already being processed. Please do not pay again. Contact us if you have not received a confirmation email.');
        }

        try {
            $result = app(PinPayments::class)->charge($this->createChargeVar($request, $order));
        } catch (\Throwable $e) {
            // No response (e.g. timeout): the card may have been charged.
            report($e);

            return $this->paymentUnconfirmed($order);
        }

        $status = $result->getStatusCode();
        $body = json_decode($result->getBody());

        if ($status == 201) {
            // payment success, update order status to paid
            $order->order_status_id = 3;
            $order->charge_token = $body->response->token ?? null;
            $order->save();

            return redirect()->route('checkout.thankyou')->with('success_message', 'Your payment has been successful.');
        }

        if ($status >= 400 && $status < 500) {
            // Pin rejected the charge (e.g. card declined), so nothing was
            // charged. Release the claim so the customer can try again.
            Order::where('id', '=', $order->id)->update(['payment_started_at' => null]);

            $error = $body->error_description ?? 'Your card could not be charged. Please check your card details.';

            return redirect()->route('checkout.card')->with('danger_message', $error)->withInput($request->except(['number', 'cvc']));
        }

        // 5xx or any other response: the outcome is unknown, so keep the order
        // claimed rather than risk charging the card twice.
        return $this->paymentUnconfirmed($order, $status . ' ' . $result->getBody());
    }

    /**
     * The card may or may not have been charged. Block further attempts on the
     * order and ask staff to check the payment in Pin.
     */
    private function paymentUnconfirmed(Order $order, $detail = 'no response')
    {
        Log::error('Card payment outcome unknown for order ' . $order->id . ': ' . $detail);

        try {
            Mail::raw(
                'The card payment for order ' . $order->id . ' (' . $order->name . ', ' . $order->email . ', $' . $order->total . ") could not be confirmed.\n\n"
                . "Check the Pin Payments dashboard to see whether the card was charged, then update the order.\n\n"
                . 'Pin response: ' . $detail,
                function ($message) use ($order) {
                    $message->to('sales@toadgully.com.au')->subject('Check card payment for order ' . $order->id);
                }
            );
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('checkout.card')->with('danger_message', 'We could not confirm your payment. Your card may have been charged, so please do not try again. We will check your payment and contact you by email.');
    }

    public function directdeposit(Request $request)
    {
        $page = Page::where('slug', '=', 'checkout')->first();
        // update order status to invoiced
        $order = Order::where('id', '=', $request->session()->get('order'))->first();

        // Don't proceed if order is null
        if (is_null($order)) {
            return redirect('/cart');
        }

        $order['order_status_id'] = 2; // invoiced
        $order->save();

        // send order email
        $orderDetails = $this->getOrderDetails($request);

        $orderDetails['subject'] = "Toad Gully Growers Invoice";

        $pdf = PDF::loadView('emails.orders.invoice', compact('orderDetails'));

        // Send invoice to customer. bcc TGG
        Mail::send('emails.orders.invoice', compact('orderDetails'), function ($message) use ($orderDetails, $pdf) {
            $message->to($orderDetails["email"], $orderDetails["name"])
                ->bcc('sales@toadgully.com.au')
                ->subject($orderDetails["subject"])
                ->attachData($pdf->output(), "invoice.pdf");
        });

        // destroy cart
        Cart::instance('cart')->destroy();

        // Forget order & customer
        $request->session()->forget(['customer', 'order']);

        return view('checkout.directdeposit', ['page' => $page, 'order' => $orderDetails]);
    }


    public function thankyou(Request $request)
    {
        $page = Page::where('slug', '=', 'thankyou')->first();
        // update order status to paid
        $order = Order::where('id', '=', $request->session()->get('order'))->first();
        // dd($order);
        // $order['order_status_id'] = 2; // Invoiced
        // $order->save();

        $cart = json_decode($order['cart']);

        // send order email
        $orderDetails = $this->getOrderDetails($request);
        $orderDetails['subject'] = "Toad Gully Growers Invoice";

        $pdf = PDF::loadView('emails.orders.paid', compact('orderDetails'));

        Mail::send('emails.orders.paid', compact('orderDetails'), function ($message) use ($orderDetails, $pdf) {
            $message->to($orderDetails["email"], $orderDetails["name"])
                ->bcc('sales@toadgully.com.au')
                ->subject($orderDetails["subject"])
                ->attachData($pdf->output(), "invoice.pdf");
        });
        // TODO Send alert to TGG
        // Mail::send(new OrderPaid($emailOrder));

        // destroy cart
        Cart::instance('cart')->destroy();

        // Forget order & customer
        $request->session()->forget(['customer', 'order']);

        return view('checkout.thankyou', ['page' => $page, 'order' => $orderDetails, 'cart' => $cart]);
    }





    protected function getOrderDetails(Request $request)
    {
        // get current order
        $order = Order::where('id', '=', $request->session()->get('order'))->first();

        $products = Cart::instance('cart')->content();

        $order["products"] = $products;


        // if (count($products)>0) {
        //     foreach ($products as $item){
        //         $cartItems[] = $item->id;
        //     }

        //     $variations = Variation::find($cartItems);
        //  }


        // TODO attach variations to product to get product code

        //  foreach ($order['products'] as $item ) {
        //      $item->code = $variations[ $item->id ];
        //     dd($item);
        //  }



        return $order;
    }

    private function getDescription()
    {
        $description = '';
        foreach (Cart::instance('cart')->content() as $row) {
            $description = $description . $row->name . ' <br> ';
        }

        return $description;
    }

    // returns a charge array
    private function createChargeVar(Request $request, Order $order)
    {
        return [
            "card" =>
            [
                "number" => $request->post('number'),
                "expiry_month"  => $request->post('month'),
                "expiry_year"  => $request->post('year'),
                "cvc"  => $request->post('cvc'),
                "name"  => $order->name,
                "address_line1"  => $order->line1,
                "address_line2" => $order->line2,
                "address_city"  => $order->city,
                "address_postcode"  => $order->postcode,
                "address_state"  => $order->state,
                "address_country"  => "Australia"
            ],
            "description"  => $this->getDescription(),
            "amount" => (int) round($order->total * 100),
            "email" => $order->email
        ];
    }
}
