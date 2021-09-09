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

                                    <p>Your order has been shipped.</p>

                                    @if ($orderDetails->tracking)
                                    <div><strong>Tracking Information: </strong>
                                        Orders are sent by Australia Post. <br />
                                        @if ($orderDetails->tracking)
                                        <strong>Tracking number: </strong> <em> {{$orderDetails->tracking}}</em>
                                        @endif
                                    </div>
                                    @endif
                                    <p>Growing notes are supplied with the plants and can also be found on the <a
                                            href="https://toadgully.com.au/paulownia">Paulownia page</a> on our website.
                                    </p>
                                    @if ($orderDetails->message)
                                    <p> {!! $orderDetails->message !!}</p>
                                    @endif

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