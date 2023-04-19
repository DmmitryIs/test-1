@extends('layout', ['title' => 'Admin: users'])
@section('content')
    <form method="post" action="{{ route('admin.user', $user->id) }}">
        @csrf
        <div class="mb-3">
            <label for="phone" class="form-label">Phone:</label>
            <div class="input-group">
                <span class="input-group-text">+</span>
                <input id="phone" name="phone" type="text" pattern="[0-9]+" minlength="10" maxlength="15" class="form-control" value="{{ $user->phone }}" required autofocus>
            </div>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input id="name" type="text" class="form-control" name="name" minlength="2" maxlength="120" value="{{ $user->id }}" required>
        </div>
        <button type="submit" class="btn btn-success">Edit</button>
    </form>
@endsection
