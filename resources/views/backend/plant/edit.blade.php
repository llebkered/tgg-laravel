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
                        Edit: {{ $plant->title }} <em>({{ $plant->botanical_name }} )</em>
                    </h1>
                </div>
            </div>
        </div>
</section>

<section>

    <div class="container">
        <form action="{{ route('backend.plants.update', $plant->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            @include('backend.plant.form')

            <div class="columns mb-6">

                @if ( $plant->getFirstMedia('featured_image') )
                <div class="column">
                    {{ $plant->getFirstMedia('featured_image') }}
                </div>
                <div class="column">
                    <label for="delete_image">Delete image</label>
                    <input type="checkbox" name="delete_image" id="delete_image">
                </div>
                @endif
            </div>

            <button class="button is-primary">Update Plant</button>
        </form>
        <form class="is-pulled-right" action="{{ route('backend.plants.destroy', $plant->id) }}" method="POST">
            @method('DELETE')
            @csrf
            <button class="button is-danger is-outlined">Delete Plant</button>
        </form>
    </div>

</section>




@endsection