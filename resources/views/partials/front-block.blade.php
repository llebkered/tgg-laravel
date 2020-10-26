<div class="section {{ $block->text_colour }} {{ $block->background_colour }}" @if ($block->background_image)
    style="background: url('{{ asset( 'storage/' . $block->background_image )}}') no-repeat center center;
    background-size: cover;"
    @endif
    >
    <div class=" content columns">
        <div
            class="column px-6 py-6 {{$block->content_background}} {{$block->content_width}} {{$block->content_position}}">
            @if ($block->heading) <h2>{{ $block->heading }}</h2> @endif
            {!! $block->content !!}
        </div>
    </div>
</div>