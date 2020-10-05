@extends('backend.layouts.main')

@section('content')

<section class="hero is-info welcome is-small mb-6">
    <div class="hero-body">
        <div class="container">
            <h1 class="title">
                Plants
            </h1>
        </div>
    </div>
</section>

<section class="panel mb-6">
    <div>
    <a href="{{ route('backend.plants.create')}}" class="button is-primary">Add new plant</a>
    </div>
    <table class="table is-hoverable">
        <thead>
            <th>ID</th>
            <th>Title</th>
            <th>Published</th>
            <th></th>
        </thead>
        <tbody>
            @foreach ($plants as $plant)
            <tr>
                <td>{{ $plant->id }}</td>
                <td>{{ $plant->title }} (<em>{{ $plant->botanical_name }}</em>)</td>
                <td>{{ $plant->published }}</td>
            <td><a href="{{ route('backend.plants.edit', $plant->id)}}" class="button is-link is-small is-outlined">edit</a></td>
            </tr>

            @endforeach
        </tbody>
    </table>
</section>

@endsection
