<section class="hero is-medium is-primary"
    @if ($hero->background_image)
        style="background: url('{{ $hero->background_image }}') no-repeat center center; background-size: cover;"
    @endif
    >
    <div class="hero-body">
        <div class="container px-6 pt-1 pb-6 has-background-trans-dark">
            <h1>{{ $hero->heading }}</h1>
            {!!$hero->content!!}
        </div>
    </div>
</section>

{{ $hero }}
