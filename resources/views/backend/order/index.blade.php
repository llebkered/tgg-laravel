@extends('backend.layouts.main')

@section('content')

<section class="hero is-info welcome is-small">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Orders
            </h1>
        </div>
    </div>
</section>

<section>
    <div class="panel content">
        <h2>Orders</h2>
        <table class="table">
            <thead>
                <th>Id</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Address</th>
                <th>Status</th>
                <th></th>
            </thead>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->address }}, {{ $order->city }}, {{ $order->state }} {{ $order->postcode }}</td>
                <td>{{ $order->order_status->title }}</td>
                <td><a href="" class="button is-primary is-small">action</a></td>
            </tr>
            @endforeach
        </table>
    </div>
</section>

@endsection
