<div class="content">
    <div class="columns is-multiline ">
        @foreach ($images as $image)
        <div class="column is-4">
            <div class="card">
                <div class="card-image">
                    <figure class="image">
                        <img src="{{ asset($image->getUrl('thumb')) }}" alt="{{ $image->getUrl('thumb') }}">
                    </figure>
                    {{ $image->id }}
                    {{ $product->id }}
                    {{ dump($image)}}
                </div>
                <div class="content">
                    <a href="/backend/medialibary/{{$product->id}}/{{ $image->id }}/delete" class="button is-danger is-small">delete</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>