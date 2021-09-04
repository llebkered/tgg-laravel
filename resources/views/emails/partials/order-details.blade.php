<table width="100%" class="full-width">
    <tr>
        <td><strong>Qty </strong></td>
        <td><strong>Item </strong> </td>
        <td class="has-text-right" align="right"><strong>Price </strong></td>
        <td class="has-text-right" align="right"><strong>Subtotal </strong> </td>
    </tr>
    @foreach ($orderDetails->products as $product)
    <tr>
        <td>{{$product->qty}} </td>
        <td>{{ $product->name }}</td>
        <td class="has-text-right" align="right">${{ number_format($product->price,2) }}</td>
        <td class="has-text-right">${{ $product->subtotal }}</td>
    </tr>
    @endforeach

    <tr>
        <td colspan="3"></td>
        <td class="has-text-right" align="right">
            <strong>GST: </strong> ${{ $orderDetails->gst }}
        </td>
    </tr>
    <tr>
        <td colspan="3"></td>
        <td class="has-text-right" align="right">
            <strong>Total: </strong> ${{ $orderDetails->total }}
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