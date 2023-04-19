@extends('layout', ['title' => 'Admin: users'])
@section('content')
    @foreach($users as $user)
        <div class="mb-3">
            <div class="display-6">{{ $user->name }}</div>
            <div>{{ $user->phone }}</div>
            <div>
                <a href="{{ route('admin.user', $user->id) }}">Edit</a>
                <a href="#">Delete</a>
            </div>
        </div>
    @endforeach
@endsection
