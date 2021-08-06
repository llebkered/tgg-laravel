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
                Edit Block
            </h1>
        </div>
    </div>
</section>

<section>
    <form action="{{ route('backend.blocks.update', $block->id)}}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        @include('backend.block.form')
        <div class="content mb-6">
            <button class="button is-primary" type="submit">Submit</button>
        </div>

    </form>
    <form class="is-pulled-right" action="{{ route('backend.blocks.destroy', $block->id) }}" method="POST">
        @method('DELETE')
        @csrf
        <button class="button is-danger is-outlined"
            onclick="return confirm('Are you sure you want to delete this?')">Delete Block</button>
    </form>

</section>

@endsection