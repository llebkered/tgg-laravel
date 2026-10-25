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
    @if ($order->paymentNeedsChecking())
    @php
    $pinMatches = $pinCharges ? \App\Actions\FindOrderCharges::matching($pinCharges) : collect();
    $pinFailed = $pinCharges ? $pinCharges->where('success', false)->where('matches_amount', true) : collect();
    $pinMatch = $pinMatches->count() === 1 ? $pinMatches->first() : null;
    // What Pin's answer means for this order: charged, several, not_charged or unknown
    $pinVerdict = match (true) {
        (bool) $pinError => 'unknown',
        (bool) $pinMatch => 'charged',
        $pinMatches->count() > 1 => 'several',
        default => 'not_charged',
    };
    $amount = '$' . number_format($order->total, 2);
    $startedAt = $order->payment_started_at->timezone('Australia/Melbourne');
    @endphp
    <div class="container mb-6">
        <div class="notification is-warning">
            <h2 class="title is-5 mb-3">Card payment not confirmed</h2>
            <p>On {{ $startedAt->format('j M Y') }} at {{ $startedAt->format('g:i a') }}, {{ $order->email }} tried to pay
                <strong>{{ $amount }}</strong> by card, but the website never heard back from Pin Payments.
                It doesn't know whether the card was charged.</p>
            <p class="mt-2">The customer was told not to pay again. The order can't be paid until you choose one of the options below.</p>

            <div class="box mt-4 mb-4">
                <p class="heading mb-1">Pin status</p>
                @if ($pinVerdict === 'unknown')
                <p class="is-size-5 mb-2"><span class="tag is-medium is-light">Couldn't check</span></p>
                <p>{{ $pinError }}</p>
                <p class="mt-2"><strong>What to do:</strong> Check the Pin Payments dashboard for a charge to {{ $order->email }} for {{ $amount }}
                    around {{ $startedAt->format('g:i a') }} on {{ $startedAt->format('j M Y') }}, then choose an option below.</p>
                @elseif ($pinVerdict === 'charged')
                <p class="is-size-5 mb-2"><span class="tag is-medium is-success">Charged</span></p>
                <p>Pin has a successful charge of ${{ number_format($pinMatch['amount'], 2) }} to {{ $order->email }}
                    on {{ $pinMatch['created_at']?->timezone('Australia/Melbourne')->format('j M Y, g:i a') }}
                    (<code>{{ $pinMatch['token'] }}</code>).</p>
                <p class="mt-2"><strong>What to do:</strong> The card was charged, so mark the order as paid. The charge token is already filled in.</p>
                @elseif ($pinVerdict === 'several')
                <p class="is-size-5 mb-2"><span class="tag is-medium is-warning">{{ $pinMatches->count() }} possible charges</span></p>
                <p>Pin has more than one successful charge that could be this order's.</p>
                <p class="mt-2"><strong>What to do:</strong> Find the right one in the list under <a href="#pin">Card payment in Pin</a>
                    and click <strong>Mark paid with this charge</strong> next to it.</p>
                @else
                <p class="is-size-5 mb-2"><span class="tag is-medium is-danger">{{ $pinFailed->isNotEmpty() ? 'Not charged' : 'No charge found' }}</span></p>
                @if ($pinFailed->isNotEmpty())
                <p>Pin only has a failed attempt for {{ $amount }}{{ $pinFailed->first()['message'] ? ' (' . $pinFailed->first()['message'] . ')' : '' }}.</p>
                @else
                <p>Pin has no successful charge to {{ $order->email }} for {{ $amount }}
                    between {{ $pinSearchDates[0]->format('j M Y') }} and {{ $pinSearchDates[1]->copy()->subDay()->format('j M Y') }}.</p>
                @endif
                <p class="mt-2"><strong>What to do:</strong> The card wasn't charged, so release the order, then let the customer know they can pay again.</p>
                @endif
            </div>

            <div class="columns mt-4">
                <div class="column">
                    <form action="{{ route('backend.orders.payment.paid', $order->id) }}" method="POST"
                        onsubmit="return confirm('Mark order #{{ $order->id }} as paid?')">
                        @csrf
                        <h3 class="title is-6 mb-2">
                            The card was charged
                            @if ($pinVerdict === 'charged')<span class="tag is-success is-light">Recommended</span>@endif
                        </h3>
                        <p class="mb-3">The order becomes Paid.</p>
                        <div class="field">
                            <label class="label" for="charge_token">Pin charge token <span class="has-text-weight-normal">(starts with ch_, optional, for your records)</span></label>
                            <div class="control">
                                <input class="input" type="text" id="charge_token" name="charge_token" placeholder="ch_..." value="{{ $pinMatch['token'] ?? '' }}">
                            </div>
                        </div>
                        <label class="checkbox">
                            <input type="checkbox" name="email_receipt" value="1" checked>
                            Email the receipt to the customer
                        </label>
                        <div class="mt-3">
                            <button type="submit" class="button is-success {{ $pinVerdict === 'charged' ? '' : 'is-outlined' }}">Mark as paid</button>
                        </div>
                    </form>
                </div>
                <div class="column">
                    <form action="{{ route('backend.orders.payment.release', $order->id) }}" method="POST"
                        onsubmit="return confirm('Release order #{{ $order->id }} so it can be paid again?')">
                        @csrf
                        <h3 class="title is-6 mb-2">
                            The card wasn't charged
                            @if ($pinVerdict === 'not_charged')<span class="tag is-danger is-light">Recommended</span>@endif
                        </h3>
                        <p class="mb-3">Releasing the order lets the customer pay again. They aren't told automatically, so contact them to let them know.</p>
                        <div class="mt-3">
                            <button type="submit" class="button is-danger {{ $pinVerdict === 'not_charged' ? '' : 'is-outlined' }}">Release the order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    @include('backend.order.pin-charges')

    {{-- <div class="container">

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
    </div> --}}

    <div class="container">
        <div class="columns has-background-light mb-6">
            <div class="column is-3">

            <a href="{{ route('backend.orders.sendshippedemail', $order->id)}}" class="button is-primary is-outlined">Send Order Shipped Email</a>

            </div>
        </div>
    </div>

    <div class="container">
        <form action="{{ route('backend.orders.update', $order->id) }}" method="POST">
            @method('PUT')
            @csrf

            <div class="columns">
                <div class="column is-2"><label class="label" for="order_status_id">Order Status</label></div>
                <div class="column">
                    <div class="control">
                        <div class="select">
                            <select name="order_status_id">
                                @foreach ($order_statuses as $status)
                                <option value="{{ $status->value }}" @selected($order->order_status_id === $status)>
                                    {{ $status->label() }}</option>
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
                <div class="column is-2"><label class="label" foline1">Address</label></div>
                <div class="column">
                    <div class="control">
                        <input class="input" name="line1" id="line1" type="text" placeholder="address"
                            value="{{ old('line1') ? old('line1') : $order->line1 }}">
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-2"><label class="label" for="line2">Line 2</label></div>
                <div class="column">
                    <div class="control">
                        <input class="input" name="line2" id="line2" type="text" placeholder="line2"
                            value="{{ old('line2') ? old('line2') : $order->line2 }}">
                    </div>
                </div>
            </div>

            <div class="columns">
                <div class="column is-2"><label class="label" for="name">Phone</label></div>
                <div class="column">
                    <div class="control">
                        <input class="input" name="phone" id="phone" type="text" placeholder="phone"
                            value="{{ old('phone') ? old('phone') : $order->phone }}">
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
                    @foreach ($order->products as $item)
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

            <div class="columns">
                <div class="column">
                    <button class="button is-primary">Update Order</button>
                </div>
                <div class="column">
                    <a href="{{ route('backend.orders.delete', $order->id) }}" class="button is-danger is-pulled-right" onclick="return confirm('Are you sure you want to delete this order?')">Delete Order</a>
                </div>
            </div>

            
        </form>
    </div>
</section>




@endsection
