<div class="content mb-6">
    <div class="field">
        <label class="label" for="title">Title</label>
        <div class="control">
            <input class="input" name="title" type="text" placeholder="Title"
                value="{{ old('title') ? old('title') : $page['title'] }}">
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
                value="{{ old('slug') ? old('slug') : $page->slug }}">
        </div>
    </div>
    @error('slug')
    <div class="notification is-danger is-light">
        <p>{{ $message }}</p>
    </div>
    @enderror
</div>

<div class="content mb-6">
    <label for="body">Content</label>
    <textarea name="body" id="" class="tinymce textarea" cols="30" rows="50">
    {{ old('body') ? old('body') : $page->body }}
    </textarea>
    @error('body')
    <div class="notification is-danger is-light">
        <p>{{ $message }}</p>
    </div>
    @enderror
</div>


<div class="content mb-6">
    <div class="field">
        <label class="label" for="meta_description">Meta Description</label>
        <div class="control">
            <input class="input" name="meta_description" type="text" placeholder="meta description"
                value="{{ old('meta_description') ? old('meta_description') : $page->meta_description }}">
        </div>
        @error('meta_description')
        <div class="notification is-danger is-light">
            <p>{{ $message }}</p>
        </div>
        @enderror
    </div>
    <div class="field">
        <label class="label" for="meta_keywords">Meta Keywords</label>
        <div class="control">
            <input class="input" name="meta_keywords" type="meta_keywords" placeholder="meta keywords"
                value="{{ old('meta_keywords') ? old('meta_keywords') : $page->meta_keywords }}">
        </div>
        @error('meta_keywords')
        <div class="notification is-danger is-light">
            <p>{{ $message }}</p>
        </div>
        @enderror
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
            <input type="radio" name="status" value="INACTIVE" {{ ($page->status =='INACTIVE') ? 'checked' :''}}>
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
                            <span class="material-icons">arrow_circle_up</span>
                        </span>
                        <span class="file-label">
                            Choose a file…
                        </span>
                    </span>
                </label>
            </div>
        </div>
        @if ($page->image)
        <div class="columns">
            <div class="column is-4 is-pulled-right ">
                <label class="checkbox has-text-danger" for="deleteimage">
                    <input type="checkbox" name="deleteimage">
                    Delete image
                </label>
            </div>
        </div>
        @endif
    </div>
    @error('image')
    <div class="notification is-danger is-light">
        <p>{{ $message }}</p>
    </div>
    @enderror
</div>
