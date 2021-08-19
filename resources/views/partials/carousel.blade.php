@section('header_extras')
<link href="{{ asset('/vendor/fancyapps/fancybox.css') }}" rel="stylesheet">
<link href="{{ asset('/vendor/fancyapps/carousel.css') }}" rel="stylesheet">
@endsection


@if ( $page->getFirstMediaUrl('gallery') )
<div id="myCarousel" class="carousel">
    @foreach ($page->getMedia('gallery') as $item)
    <div class="carousel__slide" data-src="{{ $item->getUrl('large') }}" data-fancybox="gallery" data-caption="">
        <img width="480" height="480" data-lazy-src="{{$item->getUrl('medium') }}" class="is-clickable"/>
    </div>
    @endforeach
</div>
@endif

@section('footer_extras')

<script src="{{ asset('vendor/fancyapps/fancybox.umd.js') }}" rel="stylesheet"></script>
<script src="{{ asset('vendor/fancyapps/carousel.umd.js') }}" rel="stylesheet"></script>
<script>
    // Initialise Carousel
const myCarousel = new Carousel(document.querySelector("#myCarousel"), {
  preload: 2,
});

// Customize Fancybox
Fancybox.bind('[data-fancybox="gallery"]', {
  Thumbs: true,
  Toolbar: false,

  closeButton: "top",

  Carousel: {
    Dots: true,
    on: {
      change: (that) => {
        myCarousel.slideTo(myCarousel.findPageForSlide(that.page), {
          friction: 0,
        });
      },
    },
  },
});
</script>
@endsection