<section class="box content">
    <h3>Image Gallery</h3>

    <p class="mb-6"><a href="{{ route('backend.pagegallery.create', $page->id)}}" class="button is-primary">Add new image</a> </p>
   
    <div class="box">
    <div class="columns is-multiline is-mobile">
        @foreach ($page->getMedia('gallery') as $key => $item)
        <div class="column is-one-quarter-desktop">
            <div class="card">
                <div class="card-image mb-4">
                    <img src="{{ $item->getUrl('thumb') }}" alt="thumbnail image" class="image is-fullwidth ">
                </div>
              
                <div class="has-text-centered ">
                    <a href="{{ url("backend/pages/$page->id/gallery/$item->id") }}" class="button is-danger is-outlined mb-4" onclick="return confirm('Are you sure you want to delete this?')">delete</a>
                </div>
            
            </div>

        </div>
        @endforeach
    </div>

</section>