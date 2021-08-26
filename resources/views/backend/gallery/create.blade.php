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
                New gallery image for: <a href="{{url("backend/products/$product->id")}}">{{ $product->title }}</a>
            </h1>
        </div>
    </div>
</section>

<section>
    <div class="box">
        <p class="mb-6"><a href="{{url("backend/products/$product->id")}}" class="has-text-link">Back to
                {{ $product->title }}</a></p>

        <div class="columns is-multiline is-mobile">
            <div class="column is-one-quarter-desktop">
                <div class="card">
                    <form class="box" action="{{ route('backend.productgallery.create', $product->id)}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <label class="custom-file-label label" for="gallery">Add Gallery Image</label>
                        <div class="file mb-4">

                            <input type="file" name="gallery" class="custom-file-input" id="gallery">
                        </div>
                        <button class="button is-link is-outlined">Add to gallery</button>
                    </form>
                </div>

            </div>
            @foreach ($product->getMedia('gallery') as $key => $item)
            <div class="column is-one-quarter-desktop">
                <div class="card">
                    <div class="card-image mb-4">
                        <img src="{{ $item->getUrl('thumb') }}" alt="thumbnail image" class="image is-fullwidth ">
                    </div>

                    <div class="has-text-centered ">
                        <a href="{{ url("backend/products/$product->id/gallery/$item->id") }}"
                            class="button is-danger is-outlined mb-4"
                            onclick="return confirm('Are you sure you want to delete this?')">delete</a>
                    </div>

                </div>

            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection