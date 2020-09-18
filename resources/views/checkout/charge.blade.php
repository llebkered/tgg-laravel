@extends('layouts.app')

@section('content')

<div class="container is-fluid mt-6">
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
    <div class="container is-fluid">
        <h1>{{ $page['title']}}</h1>
        {{-- <h1>{{ $page['title']}}</h1>
        {!! $page['body'] !!} --}}
<h1>Transaction</h1>
        @if (Cart::count() > 0)

        @php
        var_dump($transaction);

    @endphp


        @else
        <!-- Cart Empty -->
        <h2>Cart empty</h2>
        <p>There are no items in your cart.</p>
        @endif

    </div>
</section>

@endsection
