@extends('layouts.app')

@section('content')

<section class="section content">
    <div class="container is-fluid">
        <h1>{{ $page->title }}</h1>
        {!! $page->body !!}
    </div>
</section>

<section class="section content">
    <div class="container is-fluid">
        @foreach ($products as $product)
        <div class="product">
            <div class="columns">
                <div class="column">
                    <h2>{{ $product->title }}</h2>
                    @if ($product->image)
                    <figure>
                        <img src="{{ $product->image }}" alt="{{ $product->title }}">
                    </figure>
                    @endif
                    <div>{!! $product->description !!}</div>
                </div>
                <div class="column is-one-third has-background-light">
                    <h3>Packs</h3>
                    @foreach ($product->variations as $variation)
                    <article class="mb-6">
                        <h4>{{ $variation->title }} </h4>
                        <p>{!! $variation->description !!} </p>
                        <p>${{ number_format($variation->price, 2) }} </p>
                        <form action="{{ route('cart.store') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $variation->id}}">
                            <input type="hidden" name="name" value="{{ $product->title ." - ".$variation->title }}">
                            <input type="hidden" name="price" value="{{ $variation->price }}">
                            <button type="submit" class="button is-primary is-outlined">Add to cart</button>
                        </form>
                    </article>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>


@endsection
