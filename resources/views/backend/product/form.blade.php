@if ( $product->id )
<div class="box content">
    <h2>Variations</h2>
    <p class="mb-3"><a href="{{ route('backend.variations.create', $product->id)}}" class="button is-primary">Add new
            variation</a>
    </p>
    <div class="columns is-multiline">
        @foreach ($product->variations as $variation)
        <div class="column">
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <h3>{{ $variation->title }}</h3>
                        <h4>Description</h4>
                        <div>{!! $variation->description !!}</div>
                        <div class="my-3"><strong>Price: </strong> ${{ $variation->price }}</div>
                        <footer class="card-footer py-3">
                            <a href="{{ route('backend.variations.edit',$variation->id) }}"
                                class="button is-link is-small is-outlined">edit</a>
                        </footer>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="content mb-6">
    <div class="field">
        <label class="label" for="title">Title</label>
        <div class="control">
            <input class="input" name="title" type="text" placeholder="Title"
                value="{{ old('title') ? old('title') : $product['title'] }}">
        </div>
        @error('title')
        <div class="notification is-danger is-light">
            <p>{{ $message }}</p>
        </div>
        @enderror
    </div>

    <div class="field">
        <label class="label" for="slug">Slug</label>
        <div class="control">
            <input class="input" name="slug" type="text" placeholder="slug"
                value="{{ old('slug') ? old('slug') : $product->slug }}">
        </div>
        @error('slug')
        <div class="notification is-danger is-light">
            <p>{{ $message }}</p>
        </div>
        @enderror
    </div>

    <div class="field">
        <label class="label" for="code">Product Code</label>
        <div class="control">
            <input class="input" name="code" type="text" placeholder="product code"
                value="{{ old('code') ? old('code') : $product->code }}">
        </div>
        @error('code')
        <div class="notification is-danger is-light">
            <p>{{ $message }}</p>
        </div>
        @enderror
    </div>
</div>

<div class="content mb-6">
    <label for="description">Description</label>
    <textarea name="description" id="" class="tinymce textarea" cols="30" rows="10">
    {{ old('description') ? old('description') : $product->description }}
    </textarea>
    @error('description')
    <div class="notification is-danger is-light">
        <p>{{ $message }}</p>
    </div>
    @enderror
</div>


<div class="content mb-6">
    <div class="control">
        <span class="has-text-weight-bold">Published: </span>
        <label class="radio">
            <input type="radio" name="published" value="1" {{ ($product->published =='1') ? 'checked' :''}}>
            Published
        </label>
        <label class="radio">
            <input type="radio" name="published" value="0" {{ ($product->published =='0') ? 'checked' :''}}>
            Not Published
        </label>
    </div>

    <div class="control">
        <span class="has-text-weight-bold">In Stock: </span>
        <label class="radio">
            <input type="radio" name="stocked" value="1" {{ ($product->stocked =='1') ? 'checked' :''}}>
            In Stock
        </label>
        <label class="radio">
            <input type="radio" name="stocked" value="0" {{ ($product->stocked =='0') ? 'checked' :''}}>
            Not In Stock
        </label>
    </div>
</div>

<div class="content mb-6">
    <h4>Add Image To Gallery</h4>
    <div class="columns mb-6">
        <div class="column has-text-centered">
            <div class="control uploader">
                <span class="material-icons">upload</span>
                <span> Add image</span>
                <input type="file" name="image" accept="image/*" onchange="showMyImage(this)" value=""
                    class="button button is-link chooseFile" />
            </div>
        </div>
        <!-- Image preview -->
        <div class="field column">
            <img id="thumbnail" class="image is-128x128" src="" alt="image-preview-here" /> </div>
    </div>
</div>


@section('footer_extras')
<script>
    //function for displaying the image upload preview

function showMyImage(fileInput) {
  var files = fileInput.files;
  for (var i = 0; i < files.length; i++) {
    var file = files[i];
    var imageType = /image.*/;
    if (!file.type.match(imageType)) {
      continue;
    }
    var img = document.getElementById("thumbnail");
    img.file = file;
    var reader = new FileReader();
    reader.onload = (function(aImg) {
      return function(e) {
        aImg.src = e.target.result;
      };
    })(img);
    reader.readAsDataURL(file);
  }
}

</script>



@endsection