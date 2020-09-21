@extends('backend.layouts.main')

@section('content')

<section class="hero is-info welcome is-small mb-6">
    <div class="hero-body">
        <div class="container">
            <div class="columns">
                <div class="column">
                    <h1 class="title">
                        Edit Order #{{ $order->id }}
                    </h1>
                    <div class="has-text-weight-light">
                        <p>Created: {{ $order->created_at->format('j M, Y') }}</p>
                        <p>Updated: {{ $order->updated_at->format('j M, Y') }}</p>
                    </div>
                </div>
                <div class="column has-text-right">
                    <p>{{ $order->name  }}</p>
                    <p>${{ $order->total  }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">

        <div class="columns has-background-light mb-6">
            <div class="column">
                Order ID: {{ $order->id }}

            </div>

            <div class="column">
                Customer ID: {{ $order->customer_id }}
            </div>

            <div class="column">
                User ID: {{ $order->user_id }}
            </div>

            <div class="column">
                Address ID: {{ $order->address_id }}
            </div>
        </div>
    </div>

    <div class="container">
        <div class="columns has-background-light mb-6">
            <div class="column is-3">

            <a href="{{ route('backend.orders.sendshippedemail', $order->id)}}" class="button is-primary is-outlined">Send Order Shipped Email</a>

            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ route('backend.orders.update', $order->id) }}" method="POST">
            @csrf

            <div class="columns">
                <div class="column is-2"><label class="label" for="order_status_id">Order Status</label></div>
                <div class="column">
                    <div class="control">
                        <div class="select">
                            <select name="order_status_id">
                                @foreach ($order_statuses as $key => $value)
                                <option value="{{ $value->id }}"
                                    {{ ($order->order_status_id == $value->id) ? 'selected' : ''}}>
                                    {{ $value->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="columns">
                <div class="column is-2"><label class="label" for="name">Name</label></div>
                <div class="column">
                    <div class="control">
                        <input class="input" name="name" id="name" type="text" placeholder="Name"
                            value="{{ old('name') ? old('name') : $order->name }}">
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-2"><label class="label" for="email">Email</label></div>
                <div class="column">
                    <div class="control">
                        <input class="input" name="email" id="email" type="text" placeholder="email"
                            value="{{ old('email') ? old('email') : $order->email }}">
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-2"><label class="label" for="name">Address</label></div>
                <div class="column">
                    <div class="control">
                        <input class="input" name="address" id="address" type="text" placeholder="address"
                            value="{{ old('address') ? old('address') : $order->address }}">
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-2"><label class="label" for="name">Line 2</label></div>
                <div class="column">
                    <div class="control">
                        <input class="input" name="line2" id="line2" type="text" placeholder="line2"
                            value="{{ old('line2') ? old('line2') : $order->line2 }}">
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <div class="field">
                        <label class="label" for="city">City</label>
                        <div class="control">
                            <input class="input" name="city" id="city" type="text" placeholder="city"
                                value="{{ old('city') ? old('city') : $order->city }}">
                        </div>
                    </div>

                </div>
                <div class="column">
                    <div class="field">
                        <label class="label" for="state">State</label>
                        <div class="control">
                            <div class="select">
                                <select name="state">
                                    @foreach ($states as $key => $state)
                                    <option value="{{ $key }}" {{ ($order->state == $key) ? 'selected' : ''}}>
                                        {{ $state }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="field">
                        <label class="label" for="name">Postcode</label>
                        <div class="control">
                            <input class="input" name="postcode" id="postcode" type="text" placeholder="postcode"
                                value="{{ old('postcode') ? old('postcode') : $order->postcode }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                <h3>Order Items</h3>
                <table>
                    @foreach ($cart as $item)
                    <tr>
                        <td>{{ $item->qty }} x {{ $item->name }} {{ $item->qty }}</td>
                        <td class="has-text-right"> ${{ $item->subtotal }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td class="has-text-right"><strong>${{ $order->total}}</strong></td>
                    </tr>
                </table>
            </div>

            <div class="content">
                <h3>Comments</h3>
                <textarea class="textarea" name="comments" id="comments" cols="30" rows="10"
                    placeholder="Comments about order">{{ $order->comments}}</textarea>
            </div>

            <button class="button is-primary">Update Order</button>
        </form>
    </div>
</section>




@endsection
