<section class='content panel px-2 py-2 mb-6'>

    <div class="panel px-2 py-2 mb-4">
        <div class="columns">
            <div class="column">
                <strong>Type</strong>
                <div class="control">
                    <label class="radio">
                        <input value="1" type="radio" name="hero">
                        Hero
                    </label>
                    <label class="radio">
                        <input value="0" type="radio" name="hero">
                        Block
                    </label>
                </div>
            </div>
        </div>
    </div>



    <div class="panel content px-2 py-2 mb-3">
        <h3>Content</h3>
        <div class="columns">

            <div class="column is-1">
                <label for="weight" class="label">Weight</label>
                <div class="select"> <select name="weight">
                        @for ($i = 0; $i < 11; $i++) <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                    </select>
                </div>
            </div>
            <div class="column is-3">
                <label for="text_colour" class="label">Text Colour</label>
                <div class="select">
                    <select name="text_colour">
                        @foreach ($text_colours as $text_colour)
                        <option value="{{ $text_colour->css }}"
                            class="{{ $text_colour->css }} {{ $text_colour->background  }}">
                            {{ $text_colour->css }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="column is-3">
                <label for="background_colour" class="label">Background Colour</label>
                <div class="select">
                    <select name="background_colour">
                        @foreach ($background_colours as $background_colour)
                        <option value="{{ $background_colour->css }}"
                            class="{{ $background_colour->css }} {{ $background_colour->background  }}">
                            {{ $background_colour->css }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="column is-5">
                <strong>Background Image</strong>
                <div class="file">
                    <label class="file-label">
                        <input class="file-input" type="file" name="resume">
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

        <hr>

        <div class="content columns px-2 py-2 mb-3">
            <div class="column">
                <div class="field">
                    <label class="label" for="">Heading</label>
                    <div class="control">
                        <input name="heading" type="text" class="input">
                    </div>
                    @error('heading')
                    <div class="notification is-danger is-light">
                        <p>{{ $message }}</p>
                    </div>
                    @enderror
                </div>
            </div>

            <div class="column is-3">
                <label class="label" for="heading_colour">Heading Colour</label>
                <div class="select">
                    <select name="heading_colour">
                        @foreach ($text_colours as $text_colour)
                        <option value="{{ $text_colour->css }}"
                            class="{{ $text_colour->css }} {{ $text_colour->background  }}">
                            {{ $text_colour->css }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
        </div>

        <hr>

        <textarea name="content" class="textarea  mb-2" name="content" id="" cols="30" rows="10">
        </textarea>
        @error('content')
        <div class="notification is-danger is-light">
            <p>{{ $message }}</p>
        </div>
        @enderror

        <hr>

        <div class="columns px-2 py-2 mb-2">
            <div class="column">
                width half full
                $table->text('content_width')->nullable();

            </div>
            <div class="column">
                left right
                $table->text('content_position')->nullable();
            </div>

        </div>
    </div>
    <div class="panel content px-2 py-2 mb-3">
        <h3>Call to action</h3>
        <div class="columns px-2 py-2 mb-2">
            <div class="column">
                <label for="cta_title" class="label">Text</label>
                <input class="input" type=" text" name="cta_title" id="">
            </div>
            <div class="column">
                <label for="cta_link" class="label">Link</label>
                <input class="input" input type="text" name="cta_link" id="">
            </div>
        </div>

    </div>

    <div class="panel content px-2 py-2 mb-3">
        <label for="published" class="checkbox">
            <input type="checkbox" name="published">
            Published
        </label>
    </div>
</section>