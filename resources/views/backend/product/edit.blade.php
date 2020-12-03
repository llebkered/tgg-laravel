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
                Edit: {{ $product->title }}
            </h1>
        </div>
    </div>
</section>

<section>
    <form action="{{ route('backend.products.update', $product->id)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        @include('backend.product.form')

        <div class="columns mb-6">
            <div class="column">
            
                {{ $product->image}}
            </div>
            <div class="column">
                @if ($product->image)
                <img src="{{ asset( 'storage/' . $product->image) }}" alt="">
                @endif
            </div>
        </div>

        <div class="content mb-6">
            <button class="button is-primary" type="submit">Submit</button>
        </div>

    </form>

    <form class="is-pulled-right" action="{{ route('backend.products.destroy', $product->id) }}" method="POST">
        @method('DELETE')
        @csrf
        <button class="button is-danger">Delete Product</button>
    </form>

</section>

@endsection

@section('footer_extras')

@endsection
