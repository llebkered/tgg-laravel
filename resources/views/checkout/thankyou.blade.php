@extends('layouts.app')

@section('content')

<div class="container is-fluid mt-6">
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Delivery</a></li>
            <li><a href="#">Payment</a></li>
            <li class="is-active"><a href="#">Complete</a></li>
        </ul>
    </nav>
</div>

<section class="section content">
    <div class="container is-fluid">
        <h1>Thank You</h1>
        {{-- <h1>{{ $page['title']}}</h1>
        {!! $page['body'] !!} --}}

        <h2>Your Order</h2>
        <p>{{ $order->name }}<br>
            {{ $order->address }}<br>
            {{ $order->city }}, {{ $order->postcode }} {{ $order->state }}</p>

        <table class="table">
            @foreach ($order->products as $item)
            <tr>
                <td>
                    {{ $item->name }}
                </td>
                <td  class="has-text-right">
                    ${{ $item->price }}
                </td>
            </tr>
            @endforeach
            <tr>
                <td></td>
            <td class="has-text-right">Total: ${{ $order->total }}</td>
            </tr>
        </table>

    </div>
</section>

@endsection
