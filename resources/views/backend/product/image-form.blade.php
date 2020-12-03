<div class="content">
    <div class="columns is-multiline ">
        @foreach ($images as $image)
        <div class="column is-4">
            <div class="card">
                <div class="card-image">
                    <figure class="image">
                        <img src="{{ $image->getUrl('thumb') }}" alt="{{ $image->getUrl('thumb') }}">
                    </figure>
                    {{ $image->uuid }}
                    {{ dump($image)}}
                </div>
                <div class="content">
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>