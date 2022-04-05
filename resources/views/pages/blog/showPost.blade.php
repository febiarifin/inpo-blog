@extends('layouts.blog')

@section('content')
<div class="card bg-white container-show-post">
    <p class="fs-5">
        <a href="/" class="link-post">Post</a>/
        <a href="{{ url('user/'.$post->user->name) }}" class="link-post">{{$post->user->name }}</a>/
        {{$post->slug}}
    </p>

    <div class="mb-3">
        <img src="{{ asset($post->image) }}" class="img-fluid" alt="{{ $post->slug }}">
    </div>

    <p class="mb-3">Oleh <a href="{{ url('user/'.$post->user->name) }}" class="link-post">{{ $post->user->name }}</a>,
        Published On {{ $post->published_at
        }}</p>

    <p class="h1 mb-5 mt-3">{{ $post->title }}</p>

    <div class="p-2 fs-4">
        {!! nl2br($post->content) !!}
    </div>

    <div class="mt-5">
        Tags :
        @foreach ($post->tags as $tag)
        <span class="badge bg-light text-dark fs-5">
            <a href="{{ url('tag/'.$tag->slug)}}" class="link-post">{{ $tag->name }}</a>
        </span>
        @endforeach
    </div>

</div>

<div class="container mt-5">
    <div class="row row-cols-2">
        <div class="col-6">
            @if (isset($previous))
            <a href="{{ url('post/'.$post->user->name.'/'.$previous->id.'/'.$previous->slug) }}"
                class="btn btn-secondary form-control p-3 fs-4">{{ Str::substr($previous->title,0,20) }}</a>
            @endif
        </div>
        <div class="col-6">
            @if (isset($next))
            <a href="{{ url('post/'.$post->user->name.'/'.$next->id.'/'.$next->slug) }}"
                class="btn btn-secondary form-control p-3 fs-4">{{ Str::substr($next->title,0,20) }} </a>
            @endif
        </div>
    </div>
</div>

<div class="card bg-white p-3 mt-5">
    <div id="disqus_thread"></div>
</div>

<script id="dsq-count-scr" src="//inpo-blog.disqus.com/count.js" async></script>
<script>
    (function() {
    var d = document, s = d.createElement('script');
    s.src = 'https://inpo-blog.disqus.com/embed.js';
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by
        Disqus.</a></noscript>

@endsection