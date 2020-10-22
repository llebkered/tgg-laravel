<div class="section"
@if ($block->background_image)
style="background: url('{{ $hero->background_image }}') no-repeat center center; background-size: cover;"
@endif
>
    <div class=" content columns">
        <div class="column px-6 py-6 is-half is-offset-6">
            @if ($block->heading) <h2>{{ $block->heading }}</h2> @endif
            {!! $block->content !!}
        </div>
    </div>
</div>

{{$block}}
