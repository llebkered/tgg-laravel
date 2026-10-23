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

<section class="mb-6">
    <div class="box">
        <h2 class="title is-5">Site maintenance</h2>
        @if (option('maintenance'))
        <p class="mb-4">
            <span class="tag is-warning">On</span>
            Visitors see the maintenance page. You can still use the site while signed in as an admin.
        </p>
        <form action="{{ route('backend.maintenance') }}" method="POST">
            @csrf
            <input type="hidden" name="on" value="0">
            <button type="submit" class="button is-success">Turn maintenance off</button>
        </form>
        @else
        <p class="mb-4">
            <span class="tag is-success">Off</span>
            The site is open to everyone.
        </p>
        <form action="{{ route('backend.maintenance') }}" method="POST"
            onsubmit="return confirm('Close the site to visitors? They will see the maintenance page until you turn it off.')">
            @csrf
            <input type="hidden" name="on" value="1">
            <button type="submit" class="button is-warning">Turn maintenance on</button>
        </form>
        @endif
    </div>
</section>

<section>
    <div class="panel content mb-6">
        <h2>Orders</h2>
            @include('backend.order.list')
    </div>
</section>



@endsection
