@extends('layouts.app')

@section('header_extras')
<link href="{{ asset('/vendor/fancyapps/fancybox.css') }}" rel="stylesheet">
@endsection

@section('content')

<section class="section">
    <div class="content container is-max-widescreen">
        <h1>{{ $product->title }}</h1>

        @if ( $product->getFirstMediaUrl('gallery') )
        <div class="columns">
            @foreach ($product->getMedia('gallery') as $item)
            <div class="column ">
                <div class="card">
                    <div class="card-image mb-4">
                        <img data-fancybox="demo" 
                            data-src="{{ $item->getUrl('large') }}" 
                            srcset="{{ $item->getUrl('thumb') }} 120w,
                                     {{$item->getUrl('medium') }} 480w"
                                   
                            src=" {{$item->getUrl('thumb') }}" alt="thumbnail image"
                           
                            class="image is-fullwidth is-clickable">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="columns">
            <div class="column">

                {{-- @if ( $product->getFirstMediaUrl('featured_image') )
                <img src="{{ $product->getFirstMediaUrl('featured_image','medium') }}" alt="{{ $product->title }}">
                @endif --}}

                @if ($product->code)
                <p><strong>Code: </strong> {{$product->code }}</p>
                @endif

                <div class="mb-6">{!! $product->description !!}</div>

            </div>
            {{-- <div class="column is-one-third has-background-light">
                @if ($product->stocked)
                <h2>Packs</h2>
                @foreach ($product->variations as $variation)
                @if ($variation->is_published)
                <article class="mb-6">
                    <h3>{{ $variation->title }} </h3>
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
                @endif
                @endforeach
                @else
                <h2>Out of Stock</h2>
                <p>This item is currently out of stock.</p>
                @endif
            </div>
        </div> --}}
    </div>
    @if ($product->stocked)
    <h2>Packs</h2>
    <div class="columns">
        @foreach ($product->variations as $variation)

        @if ($variation->is_published)
        <div class="column">
            <h3>{{ $variation->title }} </h3>
            <p>{!! $variation->description !!} </p>
            <p>${{ number_format($variation->price, 2) }} </p>
            <form action="{{ route('cart.store') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $variation->id}}">
                <input type="hidden" name="name" value="{{ $product->title ." - ".$variation->title }}">
                <input type="hidden" name="price" value="{{ $variation->price }}">
                <button type="submit" class="button is-primary is-outlined">Add to cart</button>
            </form>
        </div>
        @endif

        @endforeach
        @else
        <h2>Out of Stock</h2>
        <p>This item is currently out of stock.</p>
    </div>
    @endif
</section>
@endsection

@section('footer_extras')
<script src="{{ asset('vendor/fancyapps/fancybox.umd.js') }}" rel="stylesheet"></script>
@endsection