@extends('layout')
@section('main')
    
    @include('components.createchairform' , ['user' => $user])
    @include('components.erroroutput', ['errors' => $errors])
@endsection