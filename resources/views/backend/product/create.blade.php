@extends('backend.layouts.main')

@section('header_extras')
<script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script src="{{ asset('js/tinymcesettings.js') }}" referrerpolicy="origin"></script>
@endsection

@section('content')

<section class="hero is-info welcome is-small mb-6">
    <div class="hero-body">
        <div class="container">
            <div class="columns">
                <div class="column">
                    <h1 class="title">
                        New Product
                    </h1>
                </div>
            </div>
        </div>
</section>

<section>

    <div class="container">
        <form action="{{ route('backend.products.store') }}" method="POST">
            @csrf

            @include('backend.partials.products.form')

            <button class="button is-primary">Add Products</button>
        </form>
    </div>

</section>




@endsection
