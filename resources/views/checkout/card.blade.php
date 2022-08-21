@extends('layouts.app')

@section('content')

<div class="container  is-max-widescreen mt-6">
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
    <div class="container  is-max-widescreen">
        <h1>{{ $page['title']}}</h1>
        {{-- <h1>{{ $page['title']}}</h1>s
        {!! $page['body'] !!} --}}

        @if (Cart::count() > 0)
        <div class="columns is-multiline">
            <div class="column register">
                <div class="columns">
                    <div class="column left card">
                        <h2>Credit Card</h2>
                        <form action="" method="POST">
                            {{ csrf_field() }}
                            <div class="field">
                                <label for="name" class="label">Name On Card</label>
                                <div class="control">
                                    <input name="name" class="input is-medium" type="text" placeholder="Name On Card"
                                        value="{{ $customer->name }}">
                                </div>
                            </div>
                            <div class="field">
                                <label for="number" class="label">Card Number</label>
                                <div class="control">
                                    <input name="number" class="input is-medium" type="text" placeholder="Card Number"
                                        value="{{ old('number')}}">
                                </div>
                            </div>
                            <div class="field">
                                <div class="columns">
                                    <div class="column">
                                        <label for="month" class="label">Month</label>
                                        <div class="select">
                                            <select name="month">
                                                @for ($i = 1; $i < 13; $i++)
                                                <option value="{{ $i }}"  {{old('month') == $i ? 'selected' : ''}}>
                                                    {{ date('F', mktime(0, 0, 0, $i, 10)); }}
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <label for="year" class="label">Year</label>
                                        <div class="select">
                                            <select name="year">
                                                @for ($i = 0; $i < 5; $i++)
                                                <option value="{{ $year + $i }}" {{old('year') == ($year + $i ) ? 'selected' : ''}}>
                                                    {{ $year + $i }}
                                                </option>
                                                    @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="column">
                                        <label for="cvc" class="label">CVC</label>
                                        <div class="control">
                                            <input name="cvc" class="input is-medium" type="text" placeholder="CVC"
                                                value="{{ old('cvc')}}">
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="mt-6">
                                <button class="button is-block is-primary is-fullwidth is-medium">Submit Card</button>
                            </div>
                            <p class="help">We only accept Mastercard and Visa.</p>
                        </form>

                        <div class="mt-6"><img src="{{ asset('/images/powered_by_dark_outline.svg')}}" alt=""></div>
                    </div>
                    <div class="column is-2">
                        <p class="is-size-2 has-text-centered">Or</p>
                    </div>
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
