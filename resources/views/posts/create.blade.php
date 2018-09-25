@extends('layouts.app')

@section('content')

        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf

                    @include('posts._form')

                    <button class="btn btn-success">Publish</button>
                </form>
            </div>
        </div>

@stop
