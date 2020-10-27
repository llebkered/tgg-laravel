<section class="hero is-medium {{ $hero->text_colour }} {{ $hero->background_colour }}" @if ($hero->background_image)
    style="background: url('{{ asset( 'storage/' . $hero->background_image )}}') no-repeat center center;
    background-size: cover;"
    @endif
    >
    <div class="hero-body">
        <div class=" content columns">
            <div
                class="column px-6 py-6 {{$hero->content_background}} {{$hero->content_width}} {{$hero->content_position}}">
                @if ($hero->heading) <h2>{{ $hero->heading }}</h2> @endif
                {!! $hero->content !!}
            </div>
        </div>
    </div>
</section>