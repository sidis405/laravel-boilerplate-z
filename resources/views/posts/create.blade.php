@extends('layouts.app')

@section('content')

        <div class="row">
            <div class="col-md-12">
                <form>
                    <div class="form-group">
                        <label>Article title</label>
                        <input type="text" class="form-control" name="title">
                    </div>

                    <div class="form-group">
                        <label>Insert synopsis</label>
                        <textarea name="preview" cols="30" rows="10" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Article body</label>
                        <textarea name="body" cols="30" rows="20" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Pick a category</label>
                        <select class="form-control" name="category_id">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tag this article</label>
                        <select class="form-control" name="tags[]" multiple="">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <butto class="btn btn-success">Publish</butto>
                </form>
            </div>
        </div>

@stop
