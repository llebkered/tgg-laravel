@extends('layouts.app')

@section('content')

<div class="container is-max-widescreen mt-6">
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Delivery</a></li>
            <li class="is-active"><a href="#">Payment</a></li>
            <li><a href="#">Complete</a></li>
        </ul>
    </nav>
</div>

<section class="section content">
    <div class="container is-max-widescreen">
        <h1>Thank You</h1>
        {{-- <h1>{{ $page['title']}}</h1>
        {!! $page['body'] !!} --}}

        <p class="is-size-4">Your order number is: <em>{{ $order->id }}</em></p>
        <p>{{ $order->name }}<br>
            @if ($order->line1){{$order->line1}}<br/> @endif
            @if ($order->line2){{$order->line2}}<br/> @endif
            {{ $order->city }}, {{ $order->postcode }} {{ $order->state }}</p>

        <table class="table">
            @foreach ($order->products as $item)
            <tr>
                <td>
                    {{ $item->name }}
                </td>
                <td class="has-text-right">
                    ${{ $item->price }}
                </td>
            </tr>
            @endforeach
            <tr>
                <td></td>
                <td class="has-text-right">Total: ${{ $order->total }}</td>
            </tr>
        </table>

        <div>
            <p>Please include your order number ({{ $order->id }}) to help us find your payment.</p>
            <p>Your plants will be dispatched within a few business days from payment received and we will inform you with tracking.</p>

            <p>
                <strong>Bank: </strong> {{ config('bank.name') }}<br>
                <strong>BSB: </strong> {{ config('bank.bsb') }}<br>
                <strong>Account: </strong> {{ config('bank.account') }}<br>
        </div>

    </div>
</section>

@endsection