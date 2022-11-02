<div class="content mb-6">
    <div class="field">
        <input type="hidden" name="id" value="{{ old('id') ? old('id') : $plant->id }}">
        <label class="label" for="title">Common Name</label>
        <div class="control">
            <input class="input" name="title" type="text" placeholder="common name"
                value="{{ old('title') ? old('title') : $plant->title }}">
        </div>
        @error('title')
        <div class="notification is-danger is-light">
            <p>{{ $message }}</p>
        </div>
        @enderror
    </div>

    <div class="field">
        <label class="label" for="botanical_name">Botanical Name</label>
        <div class="control">
            <input class="input" name="botanical_name" type="text" placeholder="botanical name"
                value="{{ old('botanical_name') ? old('botanical_name') : $plant->botanical_name }}">
        </div>
    </div>
    @error('botanical_name')
    <div class="notification is-danger is-light">
        <p>{{ $message }}</p>
    </div>
    @enderror
</div>

<div class="content">
    <textarea name="description" id="" class="tinymce textarea" cols="30" rows="10">
        {{ old('description') ? old('description') : $plant->description }}
    </textarea>
    @error('description')
    <div class="notification is-danger is-light">
        <p>{{ $message }}</p>
    </div>
    @enderror
</div>

<div class="content">
    <div class="columns">
        <div class="column">
            <div class="control">
                <span class="has-text-weight-bold">Published: </span>

                <label class="radio">
                    <input type="radio" name="published" value=1 {{ ($plant->published ==1) ? 'checked' :''}}>
                    Published
                </label>
                <label class="radio">
                    <input type="radio" name="published" value=0 {{ ($plant->published ==0) ? 'checked' :''}}>
                    Not published
                </label>
            </div>
        </div>
        <div class="column">
            <div class="control">
                <span class="has-text-weight-bold">Promoted: </span>

                <label class="radio">
                    <input type="radio" name="promoted" value=1 {{ ($plant->promoted ==1) ? 'checked' :''}}>
                    Promoted
                </label>
                <label class="radio">
                    <input type="radio" name="promoted" value=0 {{ ($plant->promoted ==0) ? 'checked' :''}}>
                    Not promoted
                </label>
            </div>
        </div>
        <div class="column">
            <div class="select">
                <select name="plantcategory_id">
                    @foreach ($plant_categories as $item)
                    <option value="{{ $item->id}}" {{ ($item->id == $plant->plantcategory_id) ? ' selected' : '' }}>
                        {{ $item->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>

<div class="content mb-6">
    <div class="columns has-text-weight-bold mb-6">Image</div>
    <div class="columns">
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
</div>
