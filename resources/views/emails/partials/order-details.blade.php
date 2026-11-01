<table width="100%" class="full-width">
    <tr>
        <th class="has-text-left" align="left" width="10%">Qty </th>
        <th class="has-text-left" align="left" width="50%">Item</th>
        <th width="20%" class="has-text-right" align="right">Price</th>
        <th width="20%" class="has-text-right" align="right">Subtotal</th>
    </tr>
    @foreach ($orderDetails->products as $product)
    <tr>
        <td>{{$product->qty}}</td>
        <td>{{ $product->name }} &nbsp;</td>
        <td class="has-text-right" align="right">{{ money($product->price) }}</td>
        <td class="has-text-right" align="right">{{ money($product->subtotal) }}</td>
    </tr>
    @endforeach

    <tr>
        <td colspan="4" class="has-text-right" align="right">
            <strong>Includes GST: &nbsp;</strong> {{ money($orderDetails->gstAmount()) }}
        </td>
    </tr>
    <tr>
        <td colspan="4" class="has-text-right" align="right">
            <strong>Total: &nbsp;</strong> {{ money($orderDetails->total) }} AUD
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