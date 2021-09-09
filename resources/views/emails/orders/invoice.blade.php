<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include('emails.partials.head')
</head>

<body>
    <center class="wrapper">
        <div class="webkit">
            <table class="outer" align="center">
                <tr>
                    <td>
                        {{-- Heading and Logo --}}
                        @include('emails.partials.invoice-header')
                    </td>
                </tr>

                <tr>
                    <td>
                        {{-- Tax Invoice --}}
                        <table width="100%" class="full-width">
                            <tr>
                                <td>
                                    <h1>Tax Invoice</h1>
                                </td>
                                <td class="has-text-right" align="right">
                                    <p><strong>ABN:</strong> {{ config('tgg.abn', '61 173 928 602') }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <div class="margin-bottom">
                                        <p> </p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        {{-- Order recipient --}}
                        @include('emails.partials.order-recipient')
                    </td>
                </tr>
                <tr>
                    <td>
                        {{-- Order Details --}}
                        @include('emails.partials.order-details')
                    </td>
                </tr>

                <tr>
                    <td>
                        {{-- Message --}}
                        <table width="100%">
                            <tr>
                                <td>
                                    <p>Dear {{ $orderDetails->name }},</p>
                                    <p>Thank your for your order. To pay for this please direct deposit to:</p>
                                    <p>Please include your order number ({{ $orderDetails->id }}) to help us find your payment.</p>
                                    <p>Your plants will be dispatched within a few business days from payment received and we will inform you with tracking.</p>
                                    <div>
                                        <strong>Bank: </strong> {{ config('bank.name') }}<br>
                                        <strong>BSB: </strong> {{ config('bank.bsb') }}<br>
                                        <strong>Account: </strong> {{ config('bank.account') }}
                                    </div>
                                    <p>Thank you again for choosing us.</p>

                                    <p> Regards,<br />
                                        {{ config('app.name') }}
                                    </p>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </table>

        </div>
    </center>

</body>

</html>