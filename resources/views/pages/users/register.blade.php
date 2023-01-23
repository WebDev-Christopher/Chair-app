@extends('layout')
@section('main')
    <h1 class="text-center mt-5">Register</h1>
    @include('components.registerform')
    <p class="text-center">Already have an account? <a href="/login">Login here</a></p>

    @include('components.erroroutput', ['errors' => $errors])
    
@endsection