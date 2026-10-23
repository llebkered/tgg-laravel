<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\Enums\OrderStatus;
use App\Mail\OrderShippedMail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
    public function index(Request $request)
    {
        $orders = Order::sortedBy($request->query('sort'), $request->query('direction'))->get();
        $openOrders = Order::whereIn('order_status_id', OrderStatus::open())->orderBy('id', 'DESC')->get();

        return view('backend.order.index', compact(['orders', 'openOrders']));
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
        $order_statuses = OrderStatus::cases();
        return view('backend.order.edit', compact(['order', 'order_statuses', 'states']));
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
        $request->validate([
            'order_status_id' => ['required', Rule::enum(OrderStatus::class)],
        ]);


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

    public function showOrderShippedEmail(Order $order)
    {
        return view('backend.order.orderShipped')->with('order', $order);
    }

    public function sendOrderShippedEmail(Order $order, Request $request)
    {
        $order->update($request->validate([
            'tracking' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
        ]));

        try {
            Mail::to($order)
                ->bcc(config('tgg.sales_email'))
                ->send(new OrderShippedMail($order));
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('backend.orders.sendshippedemail', $order->id)
                ->with('danger_message', 'The shipped email could not be sent: ' . $e->getMessage());
        }

        return redirect()->route('backend.orders.edit', $order->id)->with('success_message', 'Order Shipped Email has been sent.');
    }
}
