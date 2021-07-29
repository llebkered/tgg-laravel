@extends('layouts.app')

@section('header_extras')
<link href="{{ asset('public/vendor/simplelightbox/simple-lightbox.min.css') }}" rel="stylesheet">
@endsection


@section('content')

<section class="section">
    <div class="content container is-max-widescreen">
        <h1>{{ $product->title }}</h1>
        <div class="columns">
            <div class="column">

                @if ( $product->getFirstMediaUrl('featured_image') )
                <img src="{{ $product->getFirstMediaUrl('featured_image','medium') }}" alt="{{ $product->title }}">
                @endif

                {{-- <div class="gallery products-grid">
                @foreach ($product->getMedia('images') as $image)
                <a href="{{ $image->getUrl('large') }}">
                <div class="photo">
                    <img src="{{ $image->getUrl('thumb') }}" alt="{{ $image->getUrl('thumb') }}" title="" />
                </div>
                </a>
                @endforeach
            </div> --}}

            <div>{!! $product->description !!}</div>
        </div>
        <div class="column is-one-third has-background-light">
            @if ($product->stocked)
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
            @else
            <h3>Out of Stock</h3>
            <p>This item is currently out of stock.</p>
            @endif
        </div>
    </div>
    </div>
</section>
@endsection