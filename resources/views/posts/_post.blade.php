<h1>{{ $post->title }}</h1>

<img src="{{ $post->cover }}">

<p>
    {{ $post->preview }}
</p>

<p>
    {!! $post->body !!}
</p>

<p>
    Category: {{ $post->category->name }}
</p>

<p>
    Author: {{ $post->user->name }}
</p>

<p>
    Tags: {{ $post->tags->pluck('name')->implode(', ') }}
</p>
