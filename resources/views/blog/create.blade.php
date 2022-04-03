@extends('layouts.app')

@section('content')
<main class="content">
    <h1 class="h3 mb-3">{{$pages}}</h1>

    <div class="container-fluid p-0">
        <form action="post-store" method="POST" enctype="multipart/form-data">
            @method('post')
            @csrf
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <label for="">Judul artikel</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                placeholder="Masukkan judul artikel" value="{{ old('title') }}">
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
                                <option value="{{ $category->id }}">{{$category->name}}</option>
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
                                    <img class="file-preview" src="{{ asset('img/image-default.png') }}"
                                        alt="Image post" height="155" width="260">
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
                            <label for="">Konten</label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                rows="5" placeholder="Tulis konten">{{old('content')}}</textarea>
                            @error('content')
                            <div class="invalid-feedback">{{$message}}</div>
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