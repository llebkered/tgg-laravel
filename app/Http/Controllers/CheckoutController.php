<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Order;
use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Actions\ChargeOrder;
use App\Enums\ChargeStatus;
use App\Enums\OrderStatus;
use App\Events\OrderInvoiced;
use App\Events\OrderPaid;
use App\Http\Requests\CheckoutCardRequest;
use App\Http\Requests\CheckoutContactRequest;
use App\Http\Requests\CheckoutDeliveryRequest;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Variation;

use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    private const PAYMENT_IN_PROGRESS = 'A payment for this order is already being processed. Please do not pay again. Contact us if you have not received a confirmation email.';

    private const PAYMENT_UNCONFIRMED = 'We could not confirm your payment. Your card may have been charged, so please do not try again. We will check your payment and contact you by email.';

    public function index()
    {
        $page = Page::where('slug', '=', 'checkout')->firstOrFail();

        return view('checkout.index')->with(['page' => $page]);
    }

    public function contact(CheckoutContactRequest $request)
    {
        $page = Page::where('slug', '=', 'checkout')->first();

        $data = $request->validated();

        // create customer
        $customer = Customer::create($data);

        // Store in session
        $customerId = $request->session()->put('customer', $customer->id);

        // Create Order
        // $orderDetails['customer_id']  = $request->session()->get('customer');
        $orderDetails['order_status_id'] = OrderStatus::InCart->value;
        $orderDetails['cart'] = json_encode(Cart::instance('cart')->content());
        // Unformatted amounts, so totals of $1,000 or more save correctly
        $total = Cart::instance('cart')->total(2, '.', '');
        $orderDetails['tax'] = Cart::instance('cart')->tax(2, '.', '');
        $orderDetails['gst'] = Order::gstIncluded($total);
        $orderDetails['total'] = $total;
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

    public function deliverypost(CheckoutDeliveryRequest $request)
    {
        $page = Page::where('slug', '=', 'checkout')->first();

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
        if ($this->alreadyPaid($request, $order)) {
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

    public function processcard(CheckoutCardRequest $request, ChargeOrder $chargeOrder)
    {
        $order = Order::where('id', '=', $request->session()->get('order'))->first();

        // Already paid (e.g. back button or a resubmitted form)
        if ($this->alreadyPaid($request, $order)) {
            return redirect()->route('checkout.thankyou');
        }

        // Don't proceed if order is null
        if (is_null($order)) {
            return redirect('/cart');
        }

        $result = $chargeOrder($order, $request->card());

        if ($result->status === ChargeStatus::Paid) {
            $this->completePaidOrder($request, $order);

            return redirect()->route('checkout.thankyou')->with('success_message', 'Your payment has been successful.');
        }

        $message = match ($result->status) {
            ChargeStatus::Declined => $result->message,
            ChargeStatus::AlreadyClaimed => self::PAYMENT_IN_PROGRESS,
            ChargeStatus::Unconfirmed => self::PAYMENT_UNCONFIRMED,
        };

        return redirect()->route('checkout.card')->with('danger_message', $message)->withInput($request->except(['number', 'cvc']));
    }

    /**
     * Empty the cart, end the checkout and send the receipt. The paid order
     * stays in the session so the thank-you page can show it, even on refresh.
     */
    private function completePaidOrder(Request $request, Order $order)
    {
        Cart::instance('cart')->destroy();

        $request->session()->forget(['customer', 'order']);
        $request->session()->put('paid_order', $order->id);

        // The card has been charged, so a failed email must not stop the
        // checkout finishing. rescue() reports the error instead.
        rescue(fn () => OrderPaid::dispatch($order));
    }

    /**
     * True when the current order is paid, or the checkout has already
     * finished with a paid order.
     */
    private function alreadyPaid(Request $request, ?Order $order)
    {
        if ($order) {
            return $order->isPaid();
        }

        return $request->session()->has('paid_order');
    }

    public function directdeposit(Request $request)
    {
        $page = Page::where('slug', '=', 'checkout')->first();
        $order = Order::where('id', '=', $request->session()->get('order'))->first();

        // Already paid by card (e.g. back button after paying)
        if ($this->alreadyPaid($request, $order)) {
            return redirect()->route('checkout.thankyou');
        }

        // Don't proceed if order is null
        if (is_null($order)) {
            return redirect('/cart');
        }

        // A card payment has been started, so the card may have been charged
        if ($order->payment_started_at) {
            return redirect()->route('checkout.card')->with('danger_message', self::PAYMENT_IN_PROGRESS);
        }

        $order->order_status_id = OrderStatus::Invoiced->value;
        $order->save();

        Cart::instance('cart')->destroy();
        $request->session()->forget(['customer', 'order']);

        // The order is placed and this page shows how to pay, so a failed
        // email must not stop it showing. rescue() reports the error instead.
        rescue(fn () => OrderInvoiced::dispatch($order));

        return view('checkout.directdeposit', ['page' => $page, 'order' => $order]);
    }


    public function thankyou(Request $request)
    {
        $page = Page::where('slug', '=', 'thankyou')->first();

        // Only shows the order. The receipt is emailed when the payment is
        // made, so refreshing this page is safe.
        $order = Order::find($request->session()->get('paid_order') ?? $request->session()->get('order'));

        if (is_null($order) || ! $order->isPaid()) {
            return redirect('/cart');
        }

        return view('checkout.thankyou', ['page' => $page, 'order' => $order]);
    }
}
