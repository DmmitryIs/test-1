@extends('layout', ['title' => 'Main'])
@section('content')
    <div class="input-group mb-3">
        <input id="copy" type="text" class="form-control" value="{{ $url }}" aria-label="Your link" readonly>
        <button class="btn btn-outline-secondary" type="button" onclick="copy()">Copy</button>
    </div>
    <form method="post" action="{{ route('deactivate') }}">
        <div class="input-group mb-3">
            @csrf
            <input type="hidden" name="hash" value="{{ $hash }}">
            <a href="{{ route('generate') }}" class="btn btn-success col-3">Generate</a>
            <a href="{{ route('main', ['hash' => $hash, 'show' => 'win']) }}" class="btn btn-light col-3">Мені пощастить</a>
            <a href="{{ route('main', ['hash' => $hash, 'show' => 'history']) }}" class="btn btn-light col-3">Історія</a>
            <button type="submit" class="btn btn-danger col-3">Deactivate</button>
        </div>
    </form>
    @if ($click ?? null)
        <div class="mt-4">
            <div class="display-4">{{ $click->isWin() ? "Win $click->value" : 'Lose' }}!</div>
        </div>
    @endif
    @if ($history ?? null)
        @foreach($history as $click)
            <div class="display-6 mb-2">{{ $click->isWin() ? "Win $click->value" : 'Lose' }}</div>
        @endforeach
    @endif
@endsection
