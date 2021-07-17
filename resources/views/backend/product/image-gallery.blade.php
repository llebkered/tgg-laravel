<div class="content">
    <h4>Image Gallery</h4>
    <div class="columns is-multiline ">

        @if ($images)
        @forelse ($images as $image)
        <div class="column is-4">
            <div class="card">
                <div class="card-image">
                    <figure class="image">
                        <img src="{{ asset($image->getUrl('thumb')) }}" alt="{{ $image->getUrl('thumb') }}">
                    </figure>
                </div>
                <div class="content">
                    <a href="/backend/medialibary/{{ $image->id }}/delete" class="button is-danger is-small">delete</a>
                </div>
            </div>
        </div>
        @empty($images)
        <p>No images in gallery.</p>
        @endempty
        @endforeach
        @endif

    </div>
</div>