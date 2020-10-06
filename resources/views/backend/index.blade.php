@extends('backend.layouts.main')

@section('content')


<section class="hero is-info welcome is-small mb-6">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Dashboard
            </h1>
        </div>
    </div>
</section>

<section class="info-tiles mb-6">
    <div class="tile is-ancestor has-text-centered">
        <div class="tile is-parent">
            <article class="tile is-child box">
                <p class="title">{{ $orders->count() }}</p>
                <p class="subtitle">Orders</p>
            </article>
        </div>
        <div class="tile is-parent">
            <article class="tile is-child box">
                <p class="title">{{ $openOrders->count() }}</p>
                <p class="subtitle">Open Orders</p>
            </article>
        </div>
    </div>
</section>

<section>
    <div class="panel content mb-6">
        <h2>Orders</h2>
            @include('backend.order.list')
    </div>
</section>



@endsection
