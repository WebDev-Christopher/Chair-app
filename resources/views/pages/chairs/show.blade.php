@extends('layout')
@section('main')
    <div class="w-50 m-auto mt-5">
        <img src="{{asset('/storage/chairImages/'.$item->image.'')}}" class="w-50 card-img-top" alt="{{$item->id}}-{{$item->name}}">
        <h1>{{$item->name}}</h1>
        <p>{{$item->amount}}</p>
        <p>{{$item->body}}</p>
        @if ($user->id == $item->user_id)
        <div class="btn-group">
            <button class="btn btn-small btn-outline-secondary"><a href="/chair/update/{{$item->id}}">Update</a></button>
            <button class="btn btn-small btn-outline-secondary"><a href="/chair/delete/{{$item->id}}">Delete</a></button>
        </div>
        @endif
    </div>
    
@endsection