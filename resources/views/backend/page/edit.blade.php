@extends('backend.layouts.main')

@section('header_extras')
<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
    var editor_config = {
    path_absolute : "/",
    // path_absolute : "/public/storage/",
    selector: "textarea.tinymce",
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };

  tinymce.init(editor_config);

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
