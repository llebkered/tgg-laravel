@extends('layouts.app')

@section('content')

<section class="section content">
    <div class="container is-fluid">

        <h1>{{ $page->title }}</h1>
        @if ( $page->body )
        {!! $page->body !!}
        @endif

        @if (Cart::count() > 0)
        <!-- Cart -->
        <p>{{ Cart::count() }} @if (Cart::count() > 1) items @else item @endif in Shopping Cart</p>

        <table class="table is-hoverable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th></th>
                    <th class="has-text-right">Price</th>
                    <th class="has-text-right">Subtotal</th>
                    {{-- <th></th> --}}
                </tr>
            </thead>

            <tbody>
                @foreach(Cart::content() as $row)
                <tr>
                    <td>
                        <p><strong>{{ $row->name }}</strong></p>
                        <p>{{ ($row->options->has('size') ? $row->options->size : '') }}</p>
                    </td>
                    {{-- <td>{{ $row->qty  }} --}}

                    {{-- <select class="quantity" data-id="{{ $row->rowId }}"
                    data-productQuantity="{{ $row->model->quantity }}">
                    @for ($i = 1; $i < 5 + 1 ; $i++) <option {{ $row->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                        </select>
                        </td>--}}
                        <td><input type="hidden" name="qty" value="{{ $row->qty  }}"><input type="hidden" name="price"
                                value="{{ $row->price }}"></td>
                        <td class="has-text-right">${{ $row->total }}</td>
                        <td class="has-text-right">
                            <form action="{{ route('cart.destroy', $row->rowId)}}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE')}}
                                <button type="submit" class="button is-small is-danger is-outlined">Remove</button>
                            </form>

                        </td>
                </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td class="has-text-right">Subtotal</td>
                    <td class="has-text-right">${{Cart::subtotal()}}</td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td class="has-text-right">GST</td>
                    <td class="has-text-right">${{ number_format((float)Cart::total() / 10, 2)  }}</td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td class="has-text-right"><strong>Total</strong></td>
                    <td class="has-text-right"><strong>${{ Cart::total() }}</strong></td>
                </tr>
            </tfoot>
        </table>
        <div class="is-pulled-right"> <a href="{{ route('checkout.contact') }}" class="button is-primary">Proceed to
                checkout</a></div>

        @else
        <!-- Cart Empty -->
        @include('partials.cart-empty')

        @endif
    </div>
</section>


@endsection

@section('footer_extras')
{{-- <script>
    (function(){
        const classname = document.querySelectorAll('.quantity')
        Array.from(classname).forEach(function(element) {
            element.addEventListener('change', function() {
                const id = element.getAttribute('data-id')
                const productQuantity = element.getAttribute('data-productQuantity')
                axios.patch(`/cart/${id}`, {
                    quantity: this.value,
                    productQuantity: productQuantity
                })
                .then(function (response) {
                    // console.log(response);
                    window.location.href = '{{ route('cart.index') }}'
})
.catch(function (error) {
// console.log(error);
window.location.href = '{{ route('cart.index') }}'
});
})
})
})();
</script> --}}

@endsection
