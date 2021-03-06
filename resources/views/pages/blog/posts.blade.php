@extends('layouts.blog')

@section('content')

{{-- Post --}}
<div class="row gy-5 rows-cols-3">

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
                    <a href="{{ url('post/'.$post->user->name.'/'.$post->id.'/'.$post->slug) }}"
                        class="text-decoration-none link-post">{{
                        Str::substr($post->title,0,50) }}</a>
                </h5>

                <p class="text-secondary">
                    <i class="fa-solid fa-user"></i>
                    <a href="{{ url('user/'.$post->user->name) }}" class="text-decoration-none text-secondary">
                        {{ $post->user->name }}
                    </a>,
                    <i class="fa-solid fa-clock"></i> {{ $post->published_at}}
                </p>

                <p class="text-secondary">{{ Str::substr($post->content,5, 100) }}...</p>

                @foreach ($post->tags as $tag)
                <a href="{{ url('tag/'.$tag->slug) }}" class="badge bg-light text-secondary text-decoration-none">
                    {{ $tag->name }}
                </a>
                @endforeach

                <div class="mt-4">
                    <a href="{{ url('post/'.$post->user->name.'/'.$post->id.'/'.$post->slug) }}"
                        class="text-primary text-decoration-none fw-bold">Baca
                        selengkapnya...</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="text-center">
        {{ $posts->links() }}
    </div>
</div>

@endsection