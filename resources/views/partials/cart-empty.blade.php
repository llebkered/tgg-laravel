<div class="content">
    <div class="columns">
        <div class="column">
            <h2>Cart empty</h2>
            <p>There are no items in your cart.</p>
        </div>
        <div class="column">
            @if ( $page->getFirstMediaUrl('gallery') )
            <div id="myCarousel" class="carousel columns is-multiline mt-0">

                @foreach ($page->getMedia('gallery') as $item)
                <div class="carousel__slide column is-half">
                    <img data-fancybox="demo" data-src="{{ $item->getUrl('large') }}" srcset="{{$item->getUrl('medium') }} 480w,
                                {{$item->getUrl('thumb') }}  240w" sizes="(min-width: 800px) 20vw, 100vw"
                        src="{{$item->getUrl('thumb') }}" alt="thumbnail image" class="image is-fullwidth is-clickable"
                        loading="lazy">
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>