@extends('layouts.app')

@section('header_extras')
<link href="{{ asset('public/vendor/simplelightbox/simple-lightbox.min.css') }}" rel="stylesheet">
@endsection


@section('content')

<section class="section content">
    <div class="container is-max-widescreen">
        <h1>{{ $page->title }}</h1>
        {!! $page->body !!}
    </div>
</section>

<section class="section content">
    <div class="container is-max-widescreen">
        {{-- @if (option('shop')) --}}
        @foreach ($products as $key => $product)
        @if ( $key > 0)
        <hr> @endif
        <article>
            <h2><a href="{{url("/product/$product->slug")}}" class="has-text-black">{{ $product->title }}</a></h2>
            @if ( $product->getFirstMediaUrl('featured_image') )
            <a href="{{url("/product/$product->slug")}}"><img
                    src="{{ $product->getFirstMediaUrl('featured_image','medium') }}" alt="{{ $product->title }}"></a>
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
    <p>{!! Str::words($product->description, 50, '...') !!} </p>

    <p><a href="{{url("/product/$product->slug")}}" class="button is-link is-outlined">More about {{ $product->title }}
            ></a></p>

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
    </div>
    </article>
    @endforeach

    {{-- @else

    <!-- shop is closed -->
    <h2>Store closed</h2>
    <p>Our online shop is closed. It will reopen in new season.</p>

    @endif --}}
    </div>

</section>

@endsection

{{-- @section('footer_extras')
<script src="{{ asset('public/vendor/simplelightbox/simple-lightbox.js') }}"></script>
<script>
    var lightbox = new SimpleLightbox('.gallery a', { /* options */ });   
</script>

@endsection --}}