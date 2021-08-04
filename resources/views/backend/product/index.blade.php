@extends('backend.layouts.main')

@section('content')

<section class="hero is-info welcome is-small mb-6">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Products
            </h1>
        </div>
    </div>
</section>

<div class="mb-6">
    <div class="columns">
        <div class="column">
            <a href="{{ route('backend.products.create') }}" class="button is-primary">Add new product</a>
        </div>
        <div class="column">
            <div class="is-flex is-justify-content-flex-end is-align-items-center"> 
                {{-- style="display: flex; align-items: center; gap: 1rem; justify-content: center;" --}}
                
                {{-- @if (option('shop')) 
                <span class="material-icons">done</span> Shop is open &nbsp;
                <a href="{{ route('backend.shop.toggle') }}" class="button is-link is-outlined">Close shop</a>
                @else
                <span class="material-icons">closed</span>Shop is closed  &nbsp;
                <a href="{{ route('backend.shop.toggle') }}" class="button is-link is-outlined"> Open shop</a>
                @endif
                --}}             
                
            </div>
        </div>
    </div>
</div>

<section class="panel mb-6">

    <table class="table">
        <thead>
            <th>ID</th>
            <th>Title</th>
            <th>Published</th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->title }}</td>
                <td>{{ $product->published }}</td>
                <td><a href="{{ route('backend.products.edit', $product->id)}}"
                        class="button is-link is-small is-outlined">edit</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</section>


@endsection