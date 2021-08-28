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
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;
use Gloudemans\Shoppingcart\Facades\Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        $page = Page::where('slug', '=', 'checkout')->first();

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

        //create customer
        $customer = Customer::create($data);
        
        // Store in session
        $customerId = $request->session()->put('customer', $customer->id);

        // Create Order
        $orderDetails['customer_id']  = $customerId;
        $orderDetails['order_status_id'] = 1;
        $orderDetails['cart'] = json_encode(Cart::content());
        $orderDetails['tax'] = Cart::tax();
        $orderDetails['gst'] = (float)Cart::total() / 10;
        $orderDetails['total'] = Cart::total();
        $orderDetails['name'] = $request->post('name');
        $orderDetails['email'] = $request->post('email');
        $orderDetails['phone'] = $request->post('phone');

        $order = Order::create($orderDetails);
        // Store order Id in session
        $request->session()->put('order', $order->id);

        //Todo ?? Email order to tgg

        return redirect()->route('checkout.delivery')->with(['page' => $page]);
    }

    public function delivery()
    {
        $page = Page::where('slug', '=', 'checkout')->first();
        return view('checkout.delivery')->with(['page' => $page]);
    }

    public function deliverypost(Request $request)
    {
        $page = Page::where('slug', '=', 'checkout')->first();

        $rules = [
            'line1' => 'required',
            'postcode' => ['required', 'size:4', 'regex:/[2-5]\d\d\d|[0][2,7,8,9]\d\d/'], // 2-5NNN. 0[2,8,09]NN ie not WA or Tas
            'city' => 'required'];
    
        $customMessages = [
            'required' => 'The :attribute field can not be blank.',
            'postcode.size' => 'The post code must be a 4 digit number (WA and Tas not accepted.)',
            'postcode.regex' => 'Please check your postcode is correct. (WA and Tas not accepted.)'
        ];
    
        $this->validate($request, $rules, $customMessages);

        $data = $request->post();

        $order = Order::where('id', '=', $request->session()->get('order'))->first();

        $data['customer_id'] = $request->session()->get('customer');

        $address = Address::create($data);

        $order->address_id = $address->id;
        $order->address = $address->line1;
        $order->city = $address->city;
        $order->postcode = $address->postcode;
        $order->state = $address->state;

        $order->save();

        return redirect()->route('checkout.card')->with(['page' => $page]);
    }


    public function card(Request $request)
    {
        $page = Page::where('slug', '=', 'checkout')->first();

        $customer = Customer::where('id', '=', $request->session()->get('customer'))->first();

        $year = date('Y');
        return view('checkout.card', compact(['year', 'customer']))->with(['page' => $page]);
    }


    public function processcard(Request $request)
    {
        $page = Page::where('slug', '=', 'checkout')->first();

        $order = Order::where('id', '=', $request->session()->get('order'))->first();

        $charge = [
            "card" =>
            [
                "number" => $request->post('number'),
                "expiry_month"  => $request->post('month'),
                "expiry_year"  => $request->post('year'),
                "cvc"  => $request->post('cvc'),
                "name"  => $order->name,
                "address_line1"  => $order->address,
                "address_line2" => $order->line2,
                "address_city"  => $order->city,
                "address_postcode"  => $order->postcode,
                "address_state"  => $order->state,
                "address_country"  => "Australia"
            ],
            "description"  => $this->getDescription(),
            "amount" => (int)($order->total * 100),
            "email" => $order->email

        ];

        $pinPayments = new PinPayments;

        if ($pinPayments->charge($charge)) {
            // payment success
            return redirect()->route('checkout.thankyou', compact('page'))->with('success_message', 'Your payment has been successful.');
        } else {
            //payment didnt work
            return redirect()->route('checkout.card', compact('page'))->with('danger_message', 'Sorry. Something went wrong with your credit card payment. Please check your number, expiry, cvc and try again.');
        }

        
        return view('checkout.charge')->with(['page' => $page]);
    }

    public function directdeposit(Request $request)
    {
        $page = Page::where('slug', '=', 'checkout')->first();
        // update order status to invoiced
        $order = Order::where('id', '=', $request->session()->get('order'))->first();
        $order['order_status_id'] = 3; // Paid
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
        Cart::destroy();

        // Forget order & customer
        $request->session()->forget(['customer', 'order']);

        return view('checkout.directdeposit', ['page' => $page, 'order' => $orderDetails]);
    }


    public function thankyou(Request $request)
    {
        $page = Page::where('slug', '=', 'thankyou')->first();
        // update order status to paid
        $order = Order::where('id', '=', $request->session()->get('order'))->first();
        $order['order_status_id'] = 3; // Paid
        $order->save();

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
        // Todo Send alert to TGG
        // Mail::send(new OrderPaid($emailOrder));

        // destroy cart
        Cart::destroy();

        // Forget order & customer
        $request->session()->forget(['customer', 'order']);

        return view('checkout.thankyou', ['page' => $page, 'order' => $orderDetails, 'cart' => $cart]);
    }


    public function getDescription()
    {
        $description = '';
        foreach (Cart::content() as $row) {
            $description = $description . $row->name . ' <br> ';
        }

        return $description;
    }


    protected function getOrderDetails(Request $request)
    {

        // get current order
        $order = Order::where('id', '=', $request->session()->get('order'))->first();

        $products = Cart::content();

        $order["products"] = $products;

        return $order;
    }

    public function test()
    {
        $page = Page::where('slug', '=', 'thankyou')->first();


        $order = Order::where('id', '=', 14)->first();
        $cart = json_decode($order['cart']);

        $order['products'] = $cart;

        $data['order'] = $order;

        // dd( $cart);

        $pdf = PDF::loadView('emails.orders.invoice', $data);
        return $pdf->download('invoice.pdf');

        // Fetch all customers from database

        // // Send data to the view using loadView function of PDF facade
        // $pdf = PDF::loadView('emails.orders.invoice', $data);
        // // If you want to store the generated pdf to the server then you can use the store function
        // $pdf->save(storage_path().'_filename.pdf');
        // // Finally, you can download the file using download function
        // return $pdf->download('customers.pdf');



        // return view('emails.orders.invoice', ['page' => $page, 'order' => $order]);
    }
}
