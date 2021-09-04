@extends('backend.layouts.main')

@section('header_extras')
<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script src="{{ asset('js/tinymcesettings.js') }}" referrerpolicy="origin"></script>
@endsection

@section('content')

<section class="hero is-info welcome is-small mb-6">
    <div class="hero-body">
        <div class="container">
            <div class="columns">
                <div class="column">
                    <h1 class="title">
                        Send mail for order #{{ $order->id }}
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
        <div class="box mb-6">
            <div class="columns">
                <div class="column is-1"><strong>Name:</strong></div>
                <div class="column">{{ $order->name}}</div>
            </div>
            <div class="columns">
                <div class="column is-1"><strong>Email:</strong></div>
                <div class="column">{{ $order->email}}</div>
            </div>
            <div class="columns">
                <div class="column is-1"><strong>Address:</strong></div>
                <div class="column">
                    @if ($order->line1){{ $order->line1}} <br>@endif
                    @if ($order->line2) {{$order->line2}}<br>@endif
                    {{$order->city}},  {{$order->state}}  {{$order->postcode }} <br>
                </div>
            </div>
            <div class="columns">
                <div class="column is-1"><strong>Phone:</strong></div>
                <div class="column">{{ $order->phone}}</div>
            </div>
            <div class="columns">
                <div class="column is-1"><strong>Order:</strong></div>
                <div class="column">
                    <table class="table">
                        @foreach ($order->products as $item)
                        <tr>
                            <td>{{ $item->qty }}</td>
                            <td>
                                {{ $item->name }}
                            </td>
                            <td  class="has-text-right">
                                ${{ $item->price }}
                            </td>
                            <td class="has-text-right">
                                ${{ $item->subtotal }}
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3"></td>
                        <td class="has-text-right">
                            <p>GST: ${{ $order->gst }}</p>
                            <p>Total: ${{ $order->total }}</p>   
                        </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ route('backend.orders.sendshippedemail', $order->id) }}" method="POST">

            @csrf

            <div class="columns">
                <div class="column is-2"><label class="label" for="order_status_id">Tracking</label></div>
                <div class="column">
                    <div class="control">
                        <input class="input" name="tracking" id="tracking" type="text" placeholder="tracking"
                            value="{{ old('tracking') ? old('tracking') : $order->tracking }}">
                    </div>
                </div>
            </div>


            <div class="columns">
                <div class="column is-2"><label class="label" for="message">Message</label></div>
                <div class="column">
                    <div class="control">
                        <textarea class="tinymce textarea" cols="30" rows="10" name="message"
                            placeholder="optional message to customer">{{ old('message') ? old('message') : $order->message }}</textarea>
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-2"></div>
                <div class="column">
                    <button class="button is-primary">Send</button>
                </div>
            </div>

        </form>
    </div>
</section>




@endsection