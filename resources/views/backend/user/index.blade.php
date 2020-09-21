@extends('backend.layouts.main')

@section('content')

<section class="hero is-info welcome is-small mb-6">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Users
            </h1>
        </div>
    </div>
</section>

<section class="panel mb-6">
    <div>
        <a href="" class="button is-primary">Add new user</a>
    </div>
    <table class="table">
        <thead>
            <th>ID</th>
            <th>Title</th>
            <th>Published</th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td><a href="" class="button is-link is-small is-outlined">Action</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</section>


@endsection
