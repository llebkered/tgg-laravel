<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Enums\OrderStatus as OrderStatusId;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\OrderResource;

class BackendOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->get();
        $openOrders = Order::whereIn('order_status_id', OrderStatusId::open())->orderBy('id', 'DESC')->get();

        $order_statuses = OrderStatus::all();

        return view('backend.order.index', compact(['orders', 'openOrders', 'order_statuses']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        // $order = new OrderResource($order);

        return view('backend.order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $states = [
            'ACT' => 'ACT',
            'NSW' => 'New South Wales',
            'NT' => 'Northern Territory',
            'SA' => 'South Australia',
            'Qld' => 'Queensland',
            'Vic' => 'Victoria'
        ];
        $cart = json_decode($order->cart);
        $order_statuses = OrderStatus::all();
        return view('backend.order.edit', compact(['cart', 'order', 'order_statuses', 'states']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Order $order, Request $request)
    {


        // update data

        $order->update($request->only(
            [
                'order_status_id',
                // 'address_id',
                'name',
                'line1',
                'line2',
                'email',
                'city',
                'state',
                'postcode',
                'country',
                'phone',
                // 'cart',
                // 'description',
                'comments',
                // 'tax',
                // 'gst',
                // 'total'
            ]
        ));

        // send order shipped email
        // if ($order->order_status_id == 4) {
        //     $this->sendOrderShippedEmail($order);
        // }

        return redirect()->back()->with('success_message', 'Order has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::destroy($id);
        return redirect()->route('backend.orders.index')->with('success_message', 'Order has been deleted.');
    }

    public function showOrderShippedEmail($id)
    {
        // send order email
        $orderDetails = Order::find($id);

        return view('backend.order.orderShipped')->with('order', $orderDetails);
    }

    public function sendOrderShippedEmail($id, Request $request)
    {
        $orderDetails = Order::find($id);
        $orderDetails->update($request->only(
            [
                'message',
                'tracking'
            ]
        ));
        $orderDetails['subject'] = "Order from Toad Gully Growers has been shipped";

        Mail::send('emails.orders.shipped', compact('orderDetails'), function ($message) use ($orderDetails) {
            $message->to($orderDetails["email"], $orderDetails["name"])
                ->bcc('sales@toadgully.com.au')
                ->subject($orderDetails["subject"])
                ->from('sales@toadgully.com.au', 'Toad Gully Growers');
        });
        return redirect()->route('backend.orders.edit', $orderDetails->id)->with('success_message', 'Order Shipped Email has been sent.');
    }
}
