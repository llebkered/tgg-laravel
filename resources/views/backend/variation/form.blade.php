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
    <div class="columns">
        <div class="column">
            <div class="field">
                <label class="label" for="price">Price</label>
                <div class="control columns has-icons-left">
                    <input class="input column is-2" name="price" type="text" placeholder="42"
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
        <div class="column">
            <div class="field">
                <label for="is_published" class="label">Available</label>
                <div class="control">
                    <span class="has-text-weight-bold">Available for purchase: </span>
                    <label class="radio">
                        <input type="radio" name="is_published" value="1"
                            {{ ($variation->is_published =='1') ? 'checked' :''}}>
                        Available
                    </label>
                    <label class="radio">
                        <input type="radio" name="is_published" value="0"
                            {{ ($variation->is_published =='0') ? 'checked' :''}}>
                        Unavailable
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>