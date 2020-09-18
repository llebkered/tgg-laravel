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

        @if (Cart::count() > 0)
        <div class="columns is-multiline">
            <div class="column is-8 is-offset-2 register">
                <div class="columns">
                    <div class="column left card">
                        <h2>Credit Card</h2>
                        <form action="" method="POST">
                            {{ csrf_field() }}
                            <div class="field">
                                <label for="name" class="label">Name On Card</label>
                                <div class="control">
                                    <input name="name" class="input is-medium" type="text" placeholder="Name On Card"
                                        value={{ $customer->name }}>
                                </div>
                            </div>
                            <div class="field">
                                <label for="number" class="label">Card Number</label>
                                <div class="control">
                                    <input name="number" class="input is-medium" type="text" placeholder="Card Number"
                                        value={{ old('number')}}>
                                </div>
                            </div>
                            <div class="field">
                                <div class="columns">
                                    <div class="column">
                                        <label for="month" class="label">Month</label>
                                        <div class="select">
                                            <select name="month">
                                                <option value="01">Jan</option>
                                                <option value="02">Feb</option>
                                                <option value="03">Mar</option>
                                                <option value="04">Apr</option>
                                                <option value="05">May</option>
                                                <option value="06">Jun</option>
                                                <option value="07">Jan</option>
                                                <option value="08">Aug</option>
                                                <option value="09">Sep</option>
                                                <option value="10">Oct</option>
                                                <option value="11">Nov</option>
                                                <option value="12">Dec</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <label for="year" class="label">Year</label>
                                        <div class="select">
                                            <select name="year">
                                                @for ($i = 0; $i < 5; $i++) <option value="{{ $year + $i }}">
                                                    {{ $year + $i }}</option>
                                                    @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <label for="cvc" class="label">CVC</label>
                                        <div class="control">
                                            <input name="cvc" class="input is-medium" type="text" placeholder="CVC"
                                                value={{ old('cvc')}}>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="mt-6">
                                <button class="button is-block is-primary is-fullwidth is-medium">Submit Card</button>
                            </div>

                        </form>

                        <div class="mt-6"><img src="{{ asset('/images/powered_by_dark_outline.svg')}}" alt=""></div>
                    </div>
                    <div class="column is-1">Or</div>
                    <div class="column right card">
                        <h2>Direct Deposit</h2>
                        <p>You can pay by direct deposit.</p>

                        <p> Please use your order number and name as your reference number on your direct deposit.This
                            will help to process your order.</p>

                        <div class="mt-6">
                            <a href="{{ route('checkout.directdeposit') }}"
                                class="button is-block is-primary is-fullwidth is-medium">Pay By Direct Deposit</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        @else
        <!-- Cart Empty -->
        <h2>Cart empty</h2>
        <p>There are no items in your cart.</p>
        @endif

    </div>
</section>

@endsection
