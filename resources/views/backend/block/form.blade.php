<section class='content panel px-2 py-2 mb-6'>

    <div class="panel px-2 py-2 mb-4">
        <div class="columns">
            <div class="column">
                <strong>Type</strong>
                <div class="control">
                    <label class="radio">
                        <input value="1" type="radio" name="hero" @if( old('hero') || $block->hero) checked @endif>
                        Hero
                    </label>
                    <label class="radio">
                        <input value="0" type="radio" name="hero" @if( ! ( old('hero') || $block->hero)) checked @endif>
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
                <div class="select">
                    <select name="weight">
                        @for ($i = 0; $i < 11; $i++) <option value="{{ $i }}" @if(old('weight')==$i || $block->weight
                            ==$i) selected @endif>
                            {{ $i }}</option>
                            @endfor
                    </select>
                </div>
            </div>
            <div class="column is-3">
                <label for="text_colour" class="label">Text Colour</label>
                <div class="select">
                    <select name="text_colour">
                        <option value=""> </option>
                        @foreach ($text_colours as $text_colour)
                        <option value="{{ $text_colour->css }}"
                            class="{{ $text_colour->css }} {{ $text_colour->background  }}"
                            @if(old('text_colour')==$text_colour->css || $block->text_colour == $text_colour->css)
                            selected @endif>
                            {{ $text_colour->css }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="column is-3">
                <label for="background_colour" class="label">Background Colour</label>
                <div class="select">
                    <select name="background_colour">
                        <option value=""> </option>
                        @foreach ($background_colours as $background_colour)
                        <option value="{{ $background_colour->css }}"
                            class="{{ $background_colour->css }} {{ $background_colour->background  }}"
                            @if(old('background_colour')==$background_colour->css || $block->background_colour ==
                            $background_colour->css) selected @endif>
                            {{ $background_colour->css }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="column is-5 box has-background-light">
                <strong>Background Image</strong>
                <div class="columns">
                    <div class="column">
                        <div class="file">
                            <label class="file-label">
                                <input class="file-input" type="file" name="background_image">
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
                    @if ($block->background_image)
                    <div class="column">
                        {{ $block->background_image }}
                        <img src="{{ asset('storage/'. $block->background_image )}}" alt="">
                        <label class="checkbox has-text-danger" for="deleteimage">
                            <input type="checkbox" name="deleteimage">
                            Delete image
                        </label>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <hr>

        <div class="content columns px-2 py-2 mb-3">
            <div class="column">
                <div class="field">
                    <label class="label" for="">Heading</label>
                    <div class="control">
                        <input name="heading" type="text" class="input"
                            value="{{ old('heading') ? old('heading') : $block->heading }}">
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
                        <option value=""> </option>
                        @foreach ($text_colours as $text_colour)
                        <option value="{{ $text_colour->css }}"
                            class="{{ $text_colour->css }} {{ $text_colour->background  }}"
                            @if(old('heading_colour')==$text_colour->css || $block->heading_colour == $text_colour->css)
                            selected @endif>
                            {{ $text_colour->css }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>

        <hr>

        <textarea name="content" class="textarea  mb-2 tinymce" id="" cols="30" rows="10">
            {{ old('content') ? old('content') : $block->content }}
        </textarea>
        @error('content')
        <div class="notification is-danger is-light">
            <p>{{ $message }}</p>
        </div>
        @enderror

        <hr>
        @if( old('content_background')=="has-background-trans-dark" || $block->content_background=="has-background-trans-dark") selected @endif
        <div class="columns px-2 py-2 mb-2">
            <div class="column">
                <label class="label" for="content_background">Content background</label>
                <div class="select">
                    <select name="content_background">
                        <option value="">None</option>
                        <option value="has-background-trans-dark"
                        @if( old('content_background')=="has-background-trans-dark" || $block->content_background=="has-background-trans-dark") selected @endif
                        > Transparent Dark</option>
                        <option value="has-background-trans-light"
                        @if( old('content_background')=="has-background-trans-light" || $block->content_background=="has-background-trans-light") selected @endif
                        >Transparent Light</option>
                    </select>
                </div>
            </div>
            <div class="column">
                <label class="label" for="content_width">Content width</label>
                <div class="select">
                    <select name="content_width">
                        <option value="" @if( old('content_width')=="" || $block->content_width=="") selected
                            @endif>Full width</option>
                        <option value="is-half" @if(old('content_width')=="is-half" || $block->content_width=="is-half"
                            ) selected @endif>Half width
                        </option>
                    </select>
                </div>
            </div>
            <div class="column">
                <label class="label" for="content_position">Content position</label>
                <div class="select">
                    <select name="content_position">
                        <option value="" @if( old('content_position')=="" || $block->content_position=="") selected
                            @endif>Left</option>
                        <option value="is-offset-half" @if(old('content_position')=="is-offset-half" || $block->
                            content_position=="is-offset-half") selected @endif>
                            Right</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="panel content px-2 py-2 mb-3">
        <h3>Call to action</h3>
        <div class="columns px-2 py-2 mb-2">
            <div class="column">
                <label for="cta_title" class="label">Text</label>
                <input class="input" value="{{ old('cta_title') ? old('cta_title') : $block->cta_title }}" type=" text"
                    name="cta_title" id="cta_title">
            </div>
            <div class="column">
                <label for="cta_link" class="label">Link</label>
                <input class="input" value="{{ old('cta_link') ? old('cta_link') : $block->cta_link }}" type="text"
                    name="cta_link" id="cta_link">
            </div>
        </div>

    </div>

    <div class="panel content px-2 py-2 mb-3">
        <div class="control">
            <label class="radio">
                <input value="1" type="radio" name="published" @if( old('published') || $block->published) checked
                @endif>
                Published
            </label>
            <label class="radio">
                <input value="0" type="radio" name="published" @if( ! ( old('published') || $block->published)) checked
                @endif>
                Not published
            </label>
        </div>

</section>