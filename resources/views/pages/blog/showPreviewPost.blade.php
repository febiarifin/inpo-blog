@extends('layouts.blog')

@section('content')
<div class="card bg-white container-show-post">
    {{-- <p class="fs-5">
        <a href="/" class="link-post">Post</a>/
        <a href="{{ url('user/'.$post->user->name) }}" class="link-post">{{$post->user->name }}</a>/
        {{$post->slug}}
    </p> --}}

    <div class="mb-3">
        <img src="{{ asset($post->image) }}" class="img-fluid" alt="{{ $post->slug }}">
    </div>

    {{-- <p class="mb-3">Oleh <a href="{{ url('user/'.$post->user->name) }}" class="link-post">{{ $post->user->name
            }}</a>,
        Published On {{ $post->published_at
        }}</p> --}}

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

@endsection