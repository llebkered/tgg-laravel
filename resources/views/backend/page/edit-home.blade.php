@extends('backend.layouts.main')

@section('header_extras')
{{-- <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script src="{{ asset('js/tinymcesettings.js') }}" referrerpolicy="origin"></script> --}}
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

<div class="mb-6">
    <a href="{{ route('backend.blocks.create') }}" class="button is-primary">Add new block</a>
</div>

<div class="content panel px-2 py-2 mb-6">
    <h2>Hero</h2>
    @foreach ($heroes as $hero)
    <div class="content panel px-2 py-2 mb-6">
        @include('partials.front-hero')
        <div class="columns px-2 py-2 mb-3">
            <div class="column">
                <a class="button is-link is-outlined" href={{ route('backend.blocks.edit', $hero->id) }}>Edit</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="content panel px-2 py-2 mb-6">
    <h2>Sections</h2>
    @foreach ($blocks as $block)
    <div class="content panel px-2 py-2 mb-6">
        @include('partials.front-block')
        <div class="columns px-2 py-2 mb-3">
            <div class="column">
                <a class="button is-link is-outlined" href={{ route('backend.blocks.edit', $block->id) }}>Edit</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

<hr>

<section>
    <form action="{{ route('backend.pages.update', $page->id)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf

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
            <button class="button is-primary" type="submit">Submit</button>
        </div>

    </form>

</section>


<hr>

<section class="section has-background-black has-text-warning">
    <div class="container content">
        <h2 class="">Section</h2>
        <p>
            A simple container to divide your page into <strong>sections</strong>, like the one you're currently reading
        </p>
    </div>
</section>

<style>
    .bd-color {
        border-radius: 2px;
        box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .1), inset 0 0 0 1px rgba(0, 0, 0, .1);
        display: inline-block;
        float: left;
        height: 24px;
        margin-right: 8px;
        width: 24px;
    }
</style>

<section class='content panel px-2 py-2 mb-6'>
    <h2>Hero</h2>
    <div class="panel px-2 py-2 mb-4">
        <div class="columns">
            <div class="column">
                Weight
            </div>
            <div class="column">
                Text colour
            </div>
            <div class="column">
                Background colour
            </div>
            <div class="column">
                background image
            </div>
        </div>
    </div>

    <div class="panel content  px-2 py-2 mb-3">
        <h3>Heading</h3>
        <div class="field">
            <label class="label" for="">Heading</label>
            <div class="control">
                <input type="text" class="input">
            </div>
            @error('heading')
            <div class="notification is-danger is-light">
                <p>{{ $message }}</p>
            </div>
            @enderror
        </div>
        <div class="columns px-2 py-2 mb-2">
            <div class="column">
                <label class="label" for="">Heading Colour</label><span class="bd-color"
                    style="background:  hsl(48, 100%, 67%);"></span>
                <div class="select">
                    <select>
                        <option style=color:white;background:black>White Text</option>
                        <option style="color: black; background:white;">Black Text</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="panel content px-2 py-2 mb-3">
        <h3>Content</h3>
        <textarea class="textarea  mb-2" name="" id="" cols="30" rows="10">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta, deserunt. Voluptatum fugiat
            adipisci facere perferendis dolorum odio quas quisquam, dignissimos, ad quae tenetur ea neque,
            nam eveniet consequuntur ex repellendus!
        </textarea>
        <div class="panel">
            <div class="columns px-2 py-2 mb-2">
                <div class="column">
                    width half full
                </div>
                <div class="column">
                    left right
                </div>
            </div>
        </div>
    </div>
    <div class="panel content px-2 py-2 mb-3">
        <h3>Call to action</h3>
        <div class="columns px-2 py-2 mb-2">
            <div class="column">
                <label for="" class="label">Text</label>
                <input class="input type=" text" name="" id="">
            </div>
            <div class="column">
                <label for="" class="label">Link</label>
                <input class="input type=" text" name="" id="">
            </div>
            <div class="column">
                button colour
            </div>
            <div class="column">
                button size
            </div>
        </div>

    </div>

    <div class="columns px-2 py-2 mb-3">
        <div class="column">
            <button class="button is-link">Link</button>
            <button class="button is-danger is-outlined is-pulled-right">Danger</button>
        </div>
    </div>
</section>

<div class="columns">
    <div class="column">
        <div class="buttons">
            <button class="button is-primary">New block</button>
        </div>
    </div>
</div>

@endsection

@section('footer_extras')

@endsection
