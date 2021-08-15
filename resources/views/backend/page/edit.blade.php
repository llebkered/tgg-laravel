@extends('backend.layouts.main')

@section('header_extras')
<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script src="{{ asset('js/tinymcesettings.js') }}" referrerpolicy="origin"></script>
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
        @method('PUT')
        @csrf
        @include('backend.page.form')

        <div class="columns mb-6">
            @include('backend.page.image-gallery')
        </div>

        <div class="content mb-6">
            <button class="button is-primary" type="submit">Submit</button>
        </div>

    </form>
    <form class="is-pulled-right" action="{{ route('backend.pages.destroy', $page->id) }}" method="POST">
        @method('DELETE')
        @csrf
        <button class="button is-danger" onclick="return confirm('Are you sure you want to delete this?')">Delete Page</button>
    </form>

</section>

@endsection

@section('footer_extras')

@endsection
