@extends('layouts.app')

@section('content')

<section class="section content">
    <div class="container is-fluid">
        <h1>{{ $page['title']}}</h1>
        {!! $page['body'] !!}
    </div>
</section>

<section class="section">

    <div class="container is-fluid">
        <div class="columns is-multiline is-mobile">
            @foreach ($ferns as $fern)
            <div class="column is-full-mobile is-half-tablet is-one-third-desktop is-one-quarter-widescreen">
                <div class="card">
                    @if ($fern->image)
                    <div class="card-image">
                        <figure class="image  is-4by3">
                            <img src="{{ asset('storage/' . $fern->image ) }}" alt="{{ $fern->title}}">
                        </figure>
                    </div>
                    @endif
                    <div class="card-content">
                        <div class="content">
                            <h3>{{ $fern->title}}</h3>
                            <p><strong><em>{{ $fern->botanical_name}}</em></strong></p>
                            <div class="content">
                                {!! $fern->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $ferns->links('partials.pagination') }}
    </div>
</section>

@endsection
