@extends('layouts.app')

@section('content')
<main class="content">
    <h1 class="h3 mb-3">{{$pages}}</h1>

    <div class="container-fluid p-0">
        <form action="post-update" method="POST" enctype="multipart/form-data">
            @method('post')
            @csrf

            <input type="hidden" name="id" value="{{ $post->id }}">
            <input type="hidden" name="status" value="{{ $post->status }}">

            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <label for="">Judul artikel</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                placeholder="Masukkan judul artikel" value="{{ $post->title }}">
                            @error('title')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <label for="">Kategori</label>
                            <select multiple class="form-control @error('categories') is-invalid @enderror"
                                name="categories[]">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @foreach ($categoriesPost as $cat) @if ($cat->id ==
                                    $category->id)
                                    selected
                                    @endif
                                    @endforeach>
                                    {{$category->name}}
                                </option>
                                @endforeach
                            </select>
                            @error('categories')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="card" style="height: 260px; max-height: 260px">
                        <div class="card-body">
                            <label for="">Gambar</label>
                            <input type="file" name="image" id="image"
                                class="form-control @error('image') is-invalid @enderror" placeholder="choose file"
                                onchange="previewFile()">
                            @error('image')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                            <div class="mt-1 mb-1">
                                <center>
                                    <img class="file-preview" src="{{ asset($post->image) }}" alt="Image post"
                                        height="155" width="260">
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <label for="content" class="form-label">Konten</label>
                            @error('content')
                            <p class="text-danger">{{$message}}</p>
                            @enderror
                            <input id="content" type="hidden" name="content" value="{{ $post->content }}">
                            <trix-editor input="content"></trix-editor>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <label for="tags">Tags</label>
                            <input class="form-control" type="text" data-role="tagsinput" name="tags" value="@foreach($post->tags as $tag)
                            {{ $tag->name.',' }}
                            @endforeach">
                            @error('tags')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"> <i class="align-middle" data-feather="save"></i> <span
                    class="align-middle">Simpan</span></button>
        </form>
    </div>
</main>

<script>
    function previewFile(){
        const file = document.querySelector('#image');
        const filePreview = document.querySelector('.file-preview');
        filePreview.style.display = 'block';
        const oFReader = new FileReader();
        oFReader.readAsDataURL(file.files[0]);
        oFReader.onload = function(oFREvent) {
            filePreview.src = oFREvent.target.result;
        }
    }
</script>
@endsection