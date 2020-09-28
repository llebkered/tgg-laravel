<div class="content mb-6">
    <div class="field">
        <label class="label" for="name">Common Name</label>
        <div class="control">
            <input class="input" name="name" type="text" placeholder="common name"
                value="{{ old('name') ? old('name') : $plant->title }}">
        </div>
    </div>

    <div class="field">
        <label class="label" for="botanical_name">Botanical Name</label>
        <div class="control">
            <input class="input" name="botanical_name" type="text" placeholder="botanical name"
                value="{{ old('botanical_name') ? old('slug') : $plant->botanical_name }}">
        </div>
    </div>
</div>

<div class="content">
    <textarea name="" id="" class="tinymce textarea" cols="30" rows="10">
        {{ old('description') ? old('description') : $plant->description }}
    </textarea>
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
                <select name="plant_category_id">
                    @foreach ($plant_categories as $item)
                    <option value="{{ $item->id}}" {{ ($item->id == $plant->plantcategory_id) ? ' selected' : '' }}>{{ $item->title }}</option>
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

