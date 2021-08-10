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
       {{-- shop  {!! Option::get('shop') !!} --}}
        @foreach ($products as $key => $product)
        <article class="mb-6">
            <h2><a href="{{url("/product/$product->slug")}}" class="has-text-black">{{ $product->title }}</a></h2>
            <div class="columns">

                <div class="column is-3">
                    @if ( $product->getFirstMediaUrl('featured_image') )
                    <a href="{{url("/product/$product->slug")}}"><img
                            src="{{ $product->getFirstMediaUrl('featured_image','thumb') }}"
                            alt="{{ $product->title }}"></a>
                    @endif
                </div>
                <div class="column">
                    @if ($product->code)
                    <p><strong>Code: </strong> {{$product->code }}</p>
                    @endif

                    <p>{!! Str::words($product->description, 50, '...') !!} </p>

                    <p><a href="{{url("/product/$product->slug")}}" class="button is-link is-outlined">More about
                            {{ $product->title }} & purchase >
                        </a></p>
                </div>
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