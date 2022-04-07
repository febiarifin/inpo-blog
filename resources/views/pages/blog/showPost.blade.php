@extends('layouts.blog')

@section('content')
<div class="card bg-white container-show-post">
    <p class="fs-6">
        <a href="/" class="link-post">Post</a>/
        @foreach ($post->categories as $category)
        <a href="{{ url('category/'.$category->slug) }}" class="link-post">{{$category->name}}</a>
        @endforeach
        /
        {{-- <a href="{{ url('user/'.$post->user->name) }}" class="link-post">{{$post->user->name }}</a>/ --}}
        <a href="#" class="link-post">{{$post->slug}}</a>
    </p>

    <div class="mb-3">
        <img src="{{ asset($post->image) }}" class="img-fluid" alt="{{ $post->slug }}">
    </div>

    <p class="mb-3">
        <i class="fa-solid fa-user"></i>
        <a href="{{ url('user/'.$post->user->name) }}" class="link-post">{{
            $post->user->name }} </a>,
        <i class="fa-solid fa-clock"></i> {{ $post->published_at}},
        <i class="fa-solid fa-eye"></i> {{ views($post)->count() }}
    </p>

    <p class="h1 mb-5 mt-3">{{ $post->title }}</p>

    <div class="p-2 fs-4">
        {!! nl2br($post->content) !!}
    </div>

    <div class="mt-5">
        Tags :
        @foreach ($post->tags as $tag)
        <span class="badge bg-light text-dark fs-6">
            <a href="{{ url('tag/'.$tag->slug)}}" class="link-post">{{ $tag->name }}</a>
        </span>
        @endforeach
    </div>

</div>

<div class="mt-5">
    <div class="row row-cols-2">
        <div class="col-6">
            @if (isset($previous))
            <a href="{{ url('post/'.$post->user->name.'/'.$previous->id.'/'.$previous->slug) }}"
                class="btn btn-secondary form-control p-3 fs-5">
                <i class="fa-solid fa-chevron-left float-start mt-1"></i> {{
                Str::substr($previous->title,0,20) }}</a>
            @endif
        </div>
        <div class="col-6">
            @if (isset($next))
            <a href="{{ url('post/'.$post->user->name.'/'.$next->id.'/'.$next->slug) }}"
                class="btn btn-secondary form-control p-3 fs-5">
                <i class="fa-solid fa-angle-right float-end mt-1"></i>{{ Str::substr($next->title,0,20) }} </a>
            @endif
        </div>
    </div>
</div>

<div class="card bg-white p-3 mt-5">
    <div id="disqus_thread"></div>
</div>

{{-- Related Posts --}}

<div class="mt-5">
    <div class="p-1 bg-white text-center box-related">
        <p class="fs-4 mt-3">Related Post</p>
    </div>

    <div class="row gy-5 rows-cols-3 mt-3">

        @foreach ($relatedPosts as $post)
        <div class="col">
            <div class="card bg-white" style="width: 20rem;">
                <img src="{{ asset($post->image) }}" class="card-img-top" alt="Image post">
                <div class="card-body">

                    @foreach ($post->categories as $category)
                    <span class="badge-category">
                        <a href="{{ url('category/'.$category->slug) }}">{{$category->name}}</a>
                    </span>
                    @endforeach

                    <h5 class="card-title">
                        <a href="{{ url('post/'.$post->user->name.'/'.$post->id.'/'.$post->slug) }}"
                            class="link-post">{{
                            Str::substr($post->title,0,50) }}</a>
                    </h5>

                    <p class="text-secondary">
                        <a href="{{ url('user/'.$post->user->name) }}" class="text-secondary link-post">
                            {{ $post->user->name }}
                        </a>,
                        {{ $post->published_at}}
                    </p>

                    @foreach ($post->tags as $tag)
                    <a href="{{ url('tag/'.$tag->slug) }}" class="badge bg-light text-secondary link-post">
                        {{ $tag->name }}
                    </a>
                    @endforeach

                    <div class="mt-4">
                        <a href="{{ url('post/'.$post->user->name.'/'.$post->id.'/'.$post->slug) }}"
                            class="text-primary">Baca
                            selengkapnya</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Js --}}
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