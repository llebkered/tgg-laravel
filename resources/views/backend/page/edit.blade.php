@extends('backend.layouts.main')

@section('header_extras')
<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
    tinymce.init({
    selector:'.tinymce',
    plugins: 'image code',
    /* enable title field in the Image dialog*/
  image_title: true,
  /* enable automatic uploads of images represented by blob or data URIs*/
  automatic_uploads: true,
  /*
    URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
    images_upload_url: 'postAcceptor.php',
    here we add custom filepicker only to Image dialog
  */
  file_picker_types: 'image',
  /* and here's our custom image picker*/
  file_picker_callback: function (cb, value, meta) {
    var input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');

    /*
      Note: In modern browsers input[type="file"] is functional without
      even adding it to the DOM, but that might not be the case in some older
      or quirky browsers like IE, so you might want to add it to the DOM
      just in case, and visually hide it. And do not forget do remove it
      once you do not need it anymore.
    */

    input.onchange = function () {
      var file = this.files[0];

      var reader = new FileReader();
      reader.onload = function () {
        /*
          Note: Now we need to register the blob in TinyMCEs image blob
          registry. In the next release this part hopefully won't be
          necessary, as we are looking to handle it internally.
        */
        var id = 'blobid' + (new Date()).getTime();
        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
        var base64 = reader.result.split(',')[1];
        var blobInfo = blobCache.create(id, file, base64);
        blobCache.add(blobInfo);

        /* call the callback and populate the Title field with the file name */
        cb(blobInfo.blobUri(), { title: file.name });
      };
      reader.readAsDataURL(file);
    };

    input.click();
  },
  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});

</script>
@endsection

@section('content')

<section class="hero is-info welcome is-small mb-6">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Edit: {{ $page->title }}
            </h1>
        </div>
    </div>
</section>

<section>
    <form action="{{ route('backend.pages.update', $page->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="content mb-6">
            <div class="field">
                <label class="label" for="title">Title</label>
                <div class="control">
                    <input class="input" name="title" type="text" placeholder="Title"
                        value="{{ old('title') ? old('title') : $page->title }}">
                </div>
            </div>
            <div class="field">
                <label class="label" for="slug">Slug</label>
                <div class="control">
                    <input class="input" name="title" type="text" placeholder="slug"
                        value="{{ old('slug') ? old('slug') : $page->slug }}">
                </div>
            </div>
        </div>

        <div class="content mb-6">
            <label for="body">Content</label>
            <textarea name="body" id="" class="tinymce textarea" cols="30" rows="10">
            {{ $page->body }}
        </textarea>
        </div>

        <div class="content mb-6">
            <label for="excerpt">Excerpt</label>
            <textarea name="excerpt" id="" class="tinymce textarea" cols="30" rows="2">
            {{ $page->excerpt }}
        </textarea>
        </div>

        <div class="content mb-6">
            <div class="field">
                <label class="label" for="meta_description">Meta Description</label>
                <div class="control">
                    <input class="input" name="meta_description" type="text" placeholder="meta description"
                        value="{{ old('meta_description') ? old('meta_description') : $page->meta_description }}">
                </div>
            </div>
            <div class="field">
                <label class="label" for="meta_keywords">Meta Keywords</label>
                <div class="control">
                    <input class="input" name="tmeta_keywords" type="meta_keywords" placeholder="meta keywords"
                        value="{{ old('meta_keywords') ? old('meta_keywords') : $page->meta_keywords }}">
                </div>
            </div>
        </div>

        <div class="content mb-6">
            <div class="control">
                <span class="has-text-weight-bold">Status: </span>

                <label class="radio">
                    <input type="radio" name="status" value="ACTIVE" {{ ($page->status =='ACTIVE') ? 'checked' :''}}>
                    Active
                </label>
                <label class="radio">
                    <input type="radio" name="status" value="INACTIVE"
                        {{ ($page->status =='INACTIVE') ? 'checked' :''}}>
                    Inactive
                </label>
            </div>
        </div>

        <div class="content mb-6">
            <div class="columns has-text-weight-bold mb-6">Image</div>
            <div class="columns">
                <div class="columns">
                    <div class="file">
                        <label class="file-label">
                            <input class="file-input" type="file" name="image">
                            <span class="file-cta">
                                <span class="file-icon">
                                    <i class="fas fa-upload"></i>
                                </span>
                                <span class="file-label">
                                    Choose a file…
                                </span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="column">
                {{ $page->image}}
                @if ($page->image)
                <img src="{{ asset( 'storage/' . $page->image) }}" alt="">
                @endif
            </div>
        </div>

        <div class="columns">
            <button class="button is-primary" type="submit">Submit</button>
        </div>

    </form>

    {{$page}}
</section>

@endsection

@section('footer_extras')

@endsection
