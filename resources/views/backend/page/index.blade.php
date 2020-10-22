@extends('backend.layouts.main')

@section('content')

<section class="hero is-info welcome is-small mb-6">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Pages
            </h1>
        </div>
    </div>
</section>

<div class="mb-6">
    <a href="{{ route('backend.pages.create') }}" class="button is-primary">Add new page</a>
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
            @foreach ($pages as $page)
            <tr>
                <td>{{ $page->id }}</td>
                <td>{{ $page->title }}</td>
                <td>{{ $page->published }}</td>
                <td><a href="{{ route('backend.pages.edit', $page->id) }}"
                        class="button is-link is-small is-outlined">edit</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</section>



@endsection
