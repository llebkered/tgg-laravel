@extends('backend.layouts.main')

@section('content')

<section class="hero is-info welcome is-small mb-6">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                {{ $title }}
            </h1>
        </div>
    </div>
</section>

<section class="box content guide mb-6">
    {!! $guide !!}
</section>

@endsection
