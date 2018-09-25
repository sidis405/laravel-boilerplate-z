@extends('layouts.app')

@section('content')

        <div class="row">
            <div class="col-md-12">
                <form action="{{ route('posts.update', $post) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    @include('posts._form')

                    <button class="btn btn-warning">Update</button>
                </form>
            </div>
        </div>

@stop
