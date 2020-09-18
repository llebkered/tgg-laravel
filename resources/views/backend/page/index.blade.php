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

<section class="panel mb-6">
    <div>
        <a href="" class="button is-primary">Add new page</a>
    </div>
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
                <td><a href="" class="button is-primary is-small is-outlined">Action</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</section>



@endsection
