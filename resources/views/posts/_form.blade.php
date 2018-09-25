<div class="form-group">
    <label>Article title</label>
    <input type="text" class="form-control" name="title" value="{{ old('title', $post->title) }}">
</div>

<div class="form-group">
    <label>Choose a cover</label>
    <input type="file" class="form-control" name="cover">
</div>

<div class="form-group">
    <label>Insert synopsis</label>
    <textarea name="preview" cols="30" rows="10" class="form-control">{{ old('preview', $post->preview) }}</textarea>
</div>

<div class="form-group">
    <label>Article body</label>
    <textarea name="body" cols="30" rows="20" class="form-control">{{ old('body', $post->body) }}</textarea>
</div>

<div class="form-group">
    <label>Pick a category</label>
    <select class="form-control" name="category_id">
        @foreach($categories as $category)
            <option value="{{ $category->id }}" @if($category->id == old('category_id', $post->category_id)) selected="" @endif>{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Tag this article</label>
    <select class="form-control" name="tags[]" multiple="">
        @foreach($tags as $tag)
            <option value="{{ $tag->id }}"
                @if(in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray()))) selected="" @endif
                >{{ $tag->name }}</option>
        @endforeach
    </select>
</div>
