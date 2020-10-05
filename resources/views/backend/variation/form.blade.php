<div class="content mb-6">
    <div class="field">
        <label class="label" for="title">Title</label>
        <div class="control">
            <input class="input" name="title" type="text" placeholder="Title"
                value="{{ old('title') ? old('title') : $variation['title'] }}">
        </div>
        @error('title')
        <div class="notification is-danger is-light">
            <p>{{ $message }}</p>
        </div>
        @enderror
    </div>
</div>

<div class="content mb-6">
    <label for="description">Description</label>
    <textarea name="description" id="" class="tinymce textarea" cols="30" rows="10">
    {{ old('description') ? old('description') : $variation->description }}
    </textarea>
    @error('description')
    <div class="notification is-danger is-light">
        <p>{{ $message }}</p>
    </div>
    @enderror
</div>

<div class="content mb-6">
    <div class="field">
        <label class="label" for="price">Price</label>
        <div class="control has-icons-left">
            <input class="input" name="price" type="text" placeholder="42"
                value="{{ old('price') ? old('price') : $variation['price'] }}">
                <span class="icon is-small is-left">
                    $
                  </span>
        </div>
        @error('price')
        <div class="notification is-danger is-light">
            <p>{{ $message }}</p>
        </div>
        @enderror
    </div>
</div>
