@extends('layouts.app')

@section('content')

<div class="container  is-max-widescreen mt-6">
    <nav class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="#">Contact</a></li>
            <li class="is-active"><a href="#">Delivery</a></li>
            <li><a href="#">Payment</a></li>
            <li><a href="#">Complete</a></li>
        </ul>
    </nav>
</div>


<section class="section content">
    <div class="container  is-max-widescreen">
        <h1>{{ $page['title']}}</h1>

        {{-- {!! $page['body'] !!} --}}


        @if (Cart::count() > 0)
        <div class="columns is-multiline">
            <div class="column is-8 is-offset-2 register">
                <div class="columns">
                    <div class="column left">
                        <h2>Delivery Details</h2>
                        <form action="" method="POST">
                            {{ csrf_field() }}
                            <div class="field">
                                <label for="line1" class="label">Address</label>
                                <div class="control">
                                    <input name="line1" class="input is-medium" type="text" placeholder="Address Line 1"
                                        value="{{ old('line1')}}">
                                </div>
                            </div>

                            <div class="field">
                                <label for="line2" class="label">Address Line 2</label>
                                <div class="control">
                                    <input name="line2" class="input is-medium" type="email"
                                        placeholder="Address Line 2" value="{{ old('line2')}}">
                                </div>
                            </div>

                            <div class="field">
                                <label for="city" class="label">City</label>
                                <div class="control">
                                    <input name="city" class="input is-medium" type="text"
                                        placeholder="City / Town / Suburb" value="{{ old('city')}}">
                                </div>
                            </div>

                            <div class="field">
                                <label for="postcode" class="label">Postcode</label>
                                <div class="control">
                                    <input name="postcode" class="input is-medium" type="text" placeholder="Postcode"
                                        value="{{ old('postcode')}}">
                                </div>
                            </div>

                            <div class="field">
                                <label for="state" class="label">State</label>
                                <div class="select">
                                    <select name="state">
                                        <option value="ACT">ACT</option>
                                        <option value="NSW">New South Wales</option>
                                        <option value="NT">Northern Territory</option>
                                        <option value="SA">South Australia</option>
                                        <option value="Qld">Queensland</option>
                                        <option value="Vic">Victoria</option>
                                    </select>
                                </div>
                                <p class="help">Note: We don't ship to Tasmania or Western Australia.</p>

                            </div>

                            <input type="hidden" name="country" value="Australia">
                            <div class="mt-6">
                                <button class="button is-block is-primary is-fullwidth is-medium">Submit</button>
                            </div>

                        </form>
                    </div>
                    <div class="column right">
                        <img src="https://source.unsplash.com/random/400x400/?nature" alt="">
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
