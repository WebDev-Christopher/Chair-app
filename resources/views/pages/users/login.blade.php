@extends('layout')
@section('main')
    <h1 class="text-center mt-5">Login</h1>
    @include('components.loginform')
    <p class="text-center">Don't have an account? <a href="/register">Register here</a></p>
    
    @include('components.erroroutput', ['errors' => $errors])
@endsection