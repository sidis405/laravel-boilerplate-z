@extends('layouts.app')

@section('content')

    @foreach($posts as $post)
        @include('posts._post')
    @endforeach

@stop
