@extends('layout')
@section('main')
    @include('components.updatechairform', ['item' => $item])
    @include('components.erroroutput', ['errors' => $errors])
@endsection