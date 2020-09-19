@extends('backend.layouts.main')

@section('content')

<section class="hero is-info welcome is-small mb-6">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Orders
            </h1>
        </div>
    </div>
</section>

<section class="info-tiles mb-6">
    <div class="tile is-ancestor has-text-centered">
        <div class="tile is-parent">
            <article class="tile is-child box">
            <p class="title">{{ $orders->count() }}</p>
                <p class="subtitle">Orders</p>
            </article>
        </div>
        <div class="tile is-parent">
            <article class="tile is-child box">
            <p class="title">{{ $openOrders->count() }}</p>
                <p class="subtitle">Open Orders</p>
            </article>
        </div>
        <div class="tile is-parent">
            <article class="tile is-child box">
                <p class="title">3.4k</p>
                <p class="subtitle">Open Orders</p>
            </article>
        </div>
        <div class="tile is-parent">
            <article class="tile is-child box">
                <p class="title">19</p>
                <p class="subtitle">Exceptions</p>
            </article>
        </div>
    </div>
</section>

<section class="mb-6">
    <div class="columns">
        <div class="column">
            <a href="" class="button is-primary">All Orders</a>
        </div>
        <div class="column">
            <a href="" class="button is-primary">Open Orders</a>
        </div>
    </div>
</section>

<section class="mb-6">
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
