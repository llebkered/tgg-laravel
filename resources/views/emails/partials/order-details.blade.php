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
        <td class="has-text-right" align="right">${{ number_format($product->price,2) }}</td>
        <td class="has-text-right" align="right">${{ $product->subtotal }}</td>
    </tr>
    @endforeach

    <tr>
        <td colspan="4" class="has-text-right" align="right">
            <strong>GST: &nbsp;</strong> ${{ number_format($orderDetails->gstAmount(), 2) }}
        </td>
    </tr>
    <tr>
        <td colspan="4" class="has-text-right" align="right">
            <strong>Total: &nbsp;</strong> ${{ $orderDetails->total }}
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