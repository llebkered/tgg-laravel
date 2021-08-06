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

        @include('backend.product.image-featured')

        
        <div class="content mb-6">
            <button class="button is-primary is-large" type="submit">Update Product</button>
        </div>
    </form>
@include('backend.product.image-gallery')
    <form class="is-pulled-right" action="{{ route('backend.products.destroy', $product->id) }}" method="POST">
        @method('DELETE')
        @csrf
        <button class="button is-danger"  onclick="return confirm('Are you sure you want to delete this?')">Delete Product</button>
    </form>

   

</section>



@endsection

@section('footer_extras')
<script>

</script>
@endsection