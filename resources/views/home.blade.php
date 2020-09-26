@extends('layouts.app')

@section('content')
{{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

<div class="card-body">
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    {{ __('You are logged in!') }}
</div>
</div>
</div>
</div>
</div> --}}
{!! $page['body'] !!}

<div class="hero is-medium home__hero home__green">
    <div class="hero-body">
        <div class="container">
            <h1>Toad Gully Growers</h1>
            <p>Toad Gully Growers is a wholesale production nursery on the Mornington Peninsula, Victoria, Australia
                growing ferns, succulents and foliage plants for sale into the nursery industry. We also sell bare root
                Paulownia trees online, with postal delivery within Australia.</p>
        </div>
    </div>
</div>

<div id="parallax-1" class="hero is-medium home__hero">
    <div class="hero-body">
        <div class="container">
            <div class="columns">
                <div class="column is-6 is-offset-6 has-background-dark has-text-white px-6 py-6">
                    <p>We grow a wide range of potted ferns, mostly in 125mm and 180mm pots, including maidenhairs, tree
                        ferns, bird’s nest and others suited to indoors and garden. We have a popular line of small
                        hanging potted succulents and supply large pots of lush foliage including Elephant Ears in the
                        summer months and numerous varieties of tree ferns in 250mm pots.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="hero is-medium home__hero home__gradient">
    <div  class="hero is-medium ">
    <div class="hero-body">
        <div class="container">
            <div class="columns">
                <div class="column is-6 has-background-dark has-text-white px-6 py-6">
                    <p>Toad Gully Growers recognises the need for consistent high-quality stock. When ordering our
                        plants, you can be confident that your customers will be impressed. We understand that for a
                        retail nursery you need plants that look fantastic and will be snapped up quickly when times are
                        good, but are also resilient and will have a good ‘shelf life’ when sales may not be as easy to
                        come by as we’d like. With our in-house potting mix production and various growing environments,
                        we make sure each variety is produced according to its needs. This results in well grown plants
                        in the best of health. We are confident that your customers will be happy with their purchase
                        when they buy a Toad Gully plant.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="parallax-2" class="hero is-medium">
    <div class="hero-body">
        <div class="container">
            <div class="column">
                <div class="column content is-6 is-offset-6 has-background-dark has-text-white px-6 py-6">
                    <h2>Opening Hours</h2>
                    <p>We are not open to the public.</p>
                    <p>Wholesale sales visit by appointment.</p>
                    <p>
                        We only sell to ABN registered retail or landscaping businesses. (Except for seasonal postal
                        delivery of Paulownia trees.)
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
