<table width="100%">
    <tr>
        <td>
            <p><strong>Order Number: </strong> {{ $orderDetails->id }}<br />
                <strong>Order Date: </strong> {{ $orderDetails->created_at?->timezone(config('tgg.timezone'))->format('j F Y') }}</p>
        </td>
        <td class="has-text-right" align="right">
            <p> {{ $orderDetails->name }} <br />
                @if ($orderDetails->line1){{$orderDetails->line1}}<br/> @endif
                @if ($orderDetails->line2){{$orderDetails->line2}}<br/> @endif
                {{ $orderDetails->city }} {{ $orderDetails->state }}
                {{ $orderDetails->postcode }}<br />
                {{ $orderDetails->country }}<br />
                {{ $orderDetails->phone }}</p>
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