@extends('layouts.app')

@section('header_extras')
<link href="{{ asset('/vendor/fancyapps/fancybox.css') }}" rel="stylesheet">
@endsection

@section('content')

<section class="section">
    <div class="content container is-max-widescreen">
        <h1>{{ $product->title }}</h1>
        <div class="columns">
            <div class="column is-3">
                @if ( $product->getFirstMediaUrl('featured_image') )
                <img data-fancybox="demo" data-src="{{ $product->getFirstMediaUrl('featured_image','large') }}" srcset="{{$product->getFirstMediaUrl('featured_image','medium') }} 480w,
                            {{$product->getFirstMediaUrl('featured_image','thumb') }}  240w"
                    sizes="(min-width: 800px) 20vw, 100vw"
                    src="{{ $product->getFirstMediaUrl('featured_image','thumb') }}" alt="{{ $product->title }}"
                    class="image is-fullwidth is-clickable" loading="lazy">
                @endif
                <div class="columns is-multiline mt-0">
                    @if ( $product->getFirstMediaUrl('gallery') )
                    @foreach ($product->getMedia('gallery') as $item)
                    <div class="column is-half">
                        <img data-fancybox="demo" data-src="{{ $item->getUrl('large') }}" srcset="{{$item->getUrl('medium') }} 480w,
                                    {{$item->getUrl('thumb') }}  240w,
                                    {{$item->getUrl('tiny') }}  120w" sizes="(min-width: 800px) 10vw, 100vw"
                            src="{{$item->getUrl('tiny') }}" alt="thumbnail image"
                            class="image is-fullwidth is-clickable" loading="lazy">
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="column">
                <div class="mb-6">{!! $product->description !!}</div>
                @if ($product->stocked)
                <h2>Packs</h2>
                <div class="columns">
                    @foreach ($product->variations as $variation)

                    @if ($variation->is_published)
                    <div class="column">
                        <h3>{{ $variation->title }} </h3>
                        <div>{!! $variation->description !!} </div>
                        <div>${{ number_format($variation->price, 2) }} </div>
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
                    <div class="column">
                        <h2>Out of Stock</h2>
                        <p>This item is currently out of stock.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('footer_extras')
<script src="{{ asset('vendor/fancyapps/fancybox.umd.js') }}" rel="stylesheet"></script>
@endsection