@extends('layout')
@section('main')
    @include('components.updatechairform', ['item' => $item])
    @if ($errors->any() || session()->has('message'))
    <div class="text-danger">
        <ul class="list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            <li>{{ session()->get('message') }}</li>
        </ul>
    </div>
    @endif
@endsection