@extends('layouts.blog')

@section('content')

{{-- Related Post --}}
<div class="row gy-5 rows-cols-3">
    @if ($messageResult !== "")
    <div class="container mb-5" style="height: 345px">
        <div class="p-5 mt-5 bg-white bordered text-center text-uppercase">
            <h1>{!! nl2br($messageResult) !!}</h1>
        </div>
    </div>
    @endif

    @foreach ($posts as $post)
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
                    <a href="{{ url('post/'.$post->user->name.'/'.$post->id.'/'.$post->slug) }}" class="link-post">{{
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

    {{-- <div class="text-center">
        {{ $posts->links() }}
    </div> --}}
</div>

@endsection