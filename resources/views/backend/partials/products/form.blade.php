@if ( $product->id )
<div class="box content">
    <h2>Variations</h2>
    <p class="mb-3"><a href="" class="button is-primary">Add new variation</a></p>
    <div class="columns">
        @foreach ($product->variations as $variation)
        <div class="column">
            <div class="card">
                <div class="card-content">
                    <div class="content">
                        <h3>{{ $variation->title }}</h3>
                        <h4>Description</h4>
                        <div>{{ $variation->description }}</div>
                        <div class="my-3"><strong>Price: </strong> ${{ $variation->price }}</div>
                        <footer class="card-footer py-3">
                            <a href="" class="button is-link is-small is-outlined">edit</a>{{ $variation->id }}
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
</div>
