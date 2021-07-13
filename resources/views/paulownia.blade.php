@extends('layouts.app')

@section('content')

<section class="section content">
    <div class="container is-max-widescreen">
        <h1>{{ $page['title']}}</h1>
        {!! $page['body'] !!}
    </div>
</section>

@endsection