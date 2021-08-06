<section class="content box">
    <h3 class="">Featured Image</h3>
    <div class="column mb-6">
        <div class="columns">
            <div class="file">
                <label class="custom-file-label" for="featured_image">Featured Image</label>
                <input type="file" name="featured_image" class="custom-file-input" id="featured_image">
            </div>
        </div>
    </div>
    @error('image')
    <div class="notification is-danger is-light">
        <p>{{ $message }}</p>
    </div>
    @enderror

    <div class="columns mb-6">

        @if ( $product->getFirstMedia('featured_image') )
        <div class="column">
            {{ $product->getFirstMedia('featured_image') }}
        </div>
        <div class="column">
            <label for="delete_image">Delete image</label>
            <input type="checkbox" name="delete_image" id="delete_image">
        </div>
        @endif
    </div>
  
</section>