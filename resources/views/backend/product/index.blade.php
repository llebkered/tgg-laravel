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
    <a href="{{ route('backend.products.create') }}" class="button is-primary">Add new product</a>
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
