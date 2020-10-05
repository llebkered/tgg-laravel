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
        @csrf
        @include('backend.page.form')

        <div class="columns mb-6">
            <div class="column">
                {{ $page->image}}
            </div>
            <div class="column">
                @if ($page->image)
                <img src="{{ asset( 'storage/' . $page->image) }}" alt="">
                @endif
            </div>
        </div>

        <div class="content mb-6">
            <button class="button is-primary" type="submit">Submit</button>
        </div>

    </form>

</section>

@endsection

@section('footer_extras')

@endsection
