{{-- Card payment details from Pin Payments, for orders paid or being paid by card --}}
@if ($order->charge_token || $order->payment_started_at)
<div class="container mb-6" id="pin">
    <div class="box">
        <h2 class="title is-5">Card payment in Pin</h2>

        @if ($order->charge_token)
        <p class="mb-3">Pin charge: <code>{{ $order->charge_token }}</code></p>
        @endif

        @if (is_null($pinCharges) && is_null($pinError))
        <p class="mb-3">
            @if ($order->charge_token)
            See the charge's current status in Pin.
            @else
            Look for charges to {{ $order->email }} around the time the payment started.
            @endif
        </p>
        <a href="{{ route('backend.orders.edit', ['order' => $order->id, 'check_pin' => 1]) }}#pin"
            class="button is-link is-outlined">Check with Pin</a>

        @elseif ($pinError)
        <div class="notification is-danger is-light">
            <p>Pin could not be checked. {{ $pinError }}</p>
            <p>Try again, or check the Pin Payments dashboard.</p>
        </div>
        <a href="{{ route('backend.orders.edit', ['order' => $order->id, 'check_pin' => 1]) }}#pin"
            class="button is-link is-outlined">Try again</a>

        @elseif ($pinCharges->isEmpty())
        <div class="notification is-light">
            @if ($order->charge_token)
            <p>Pin has no charge with this token. Check the PIN_HOST setting points to the same Pin account (test or live) that took the payment.</p>
            @else
            <p>Pin has no charges to {{ $order->email }} between {{ $pinSearchDates[0]->format('j M Y') }} and {{ $pinSearchDates[1]->copy()->subDay()->format('j M Y') }}.</p>
            @if ($order->paymentNeedsChecking())
            <p>If you're sure it isn't in Pin, release the order so it can be paid again.</p>
            @endif
            @endif
        </div>

        @else
        @unless ($order->charge_token)
        <p class="mb-3">Charges to {{ $order->email }} between
            {{ $pinSearchDates[0]->format('j M Y') }} and {{ $pinSearchDates[1]->copy()->subDay()->format('j M Y') }}.
            This order is for <strong>${{ number_format($order->total, 2) }}</strong>.</p>
        @endunless
        <div class="table-container">
            <table class="table is-fullwidth">
                <thead>
                    <tr>
                        <th>When</th>
                        <th class="has-text-right">Amount</th>
                        <th>Result</th>
                        <th>Description</th>
                        <th>Token</th>
                        @if ($order->paymentNeedsChecking())
                        <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pinCharges as $charge)
                    <tr>
                        <td>{{ $charge['created_at']?->timezone('Australia/Melbourne')->format('j M Y, g:i a') }}</td>
                        <td class="has-text-right">
                            ${{ number_format($charge['amount'], 2) }}
                            @if ($charge['matches_amount'])
                            <br><span class="tag is-info is-light">Matches order</span>
                            @endif
                        </td>
                        <td>
                            @if ($charge['success'] && $charge['captured'])
                            <span class="tag is-success">Charged</span>
                            @elseif ($charge['success'])
                            <span class="tag is-warning">Authorised, not captured</span>
                            @else
                            <span class="tag is-danger">Failed</span>
                            @endif
                            @if ($charge['for_this_order'])
                            <span class="tag is-info">This order</span>
                            @endif
                            @if ($charge['message'])
                            <br><small>{{ $charge['message'] }}</small>
                            @endif
                        </td>
                        <td><small>{{ strip_tags($charge['description']) }}</small></td>
                        <td><code>{{ $charge['token'] }}</code></td>
                        @if ($order->paymentNeedsChecking())
                        <td>
                            @if ($charge['success'])
                            <form action="{{ route('backend.orders.payment.paid', $order->id) }}" method="POST"
                                onsubmit="return confirm('Mark order #{{ $order->id }} as paid with charge {{ $charge['token'] }}?')">
                                @csrf
                                <input type="hidden" name="charge_token" value="{{ $charge['token'] }}">
                                <label class="checkbox is-size-7 mb-2">
                                    <input type="checkbox" name="email_receipt" value="1" checked>
                                    Email receipt
                                </label>
                                <button type="submit" class="button is-success is-small">Mark paid with this charge</button>
                            </form>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endif
