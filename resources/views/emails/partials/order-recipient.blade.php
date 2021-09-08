<table width="100%">
    <tr>
        <td>
            <p><strong>Order Number: </strong> {{ $orderDetails->id }}</p>
        </td>
        <td class="has-text-right" align="right">
            <p> {{ $orderDetails->name }} <br />
                @if ($orderDetails->line1){{$orderDetails->line1}}<br/> @endif
                @if ($orderDetails->line2){{$orderDetails->line2}}<br/> @endif
                {{ $orderDetails->city }} {{ $orderDetails->state }}
                {{ $orderDetails->postcode }}<br />
                {{ $orderDetails->country }}</p>
                {{ $orderDetails->phone }} <br />
            <p> </p>
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