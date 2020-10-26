<section class="hero is-medium {{ $hero->text_colour }} {{ $hero->background_colour }}"
    @if ($hero->background_image)
        style="background: url({{ asset( 'storage/' . $hero->background_image )}}) no-repeat center center; background-size: cover;"
    @endif
    >
    <div class="hero-body">
    <div class="container px-6 pt-1 pb-6 {{ $hero->content_background}} {{$hero->content_width}} {{$hero->content_position}}">
        <h1 class="is-size-1 {{ $hero->heading_colour}}">{{ $hero->heading }}</h1>
            {!!$hero->content!!}
        </div>
    </div>
</section>

