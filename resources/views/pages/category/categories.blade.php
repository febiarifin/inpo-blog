@extends('layouts.app')

@section('content')
<main class="content">
    <h1 class="h3 mb-3">{{ $pages }}</h1>
    <div class="container-fluid p-0">
        <div class="card">
            <div class="card-body">
                <form action="{{ $form }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{$categoryId}}">
                    <label for="">Nama kategori</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror "
                            placeholder="Masukkan nama kategori" aria-label="Recipient's username"
                            aria-describedby="button-addon2" name="name" value="{{$categoryName}}">
                        <button class="btn btn-primary" type="submit" id="button-addon2">{{$buttonText}}</button>
                    </div>
                    @error('name')
                    <span class="text-danger text-sm">{{ $message }}</span>
                    @enderror
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr class="text-center">
                        <th>NO</th>
                        <th>NAME</th>
                        <th>SLUG</th>
                        <th>CREATED AT</th>
                        <th>AKSI</th>
                    </tr>

                    @foreach ($categories as $category)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->created_at}}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <form action="category-edit" method="post">
                                    @method('post')
                                    @csrf
                                    <input type="hidden" name="id" value="{{$category->id}}">
                                    <input type="hidden" name="name" value="{{$category->name}}">
                                    <button class="btn btn-primary btn-sm" type="submit">Edit</button>
                                </form>

                                <form action="category-delete" method="post">
                                    @method('post')
                                    @csrf
                                    <input type="hidden" name="id" value="{{$category->id}}">
                                    <button class="btn btn-danger btn-sm" type="submit"
                                        onclick="confirmDelete()">Hapus</button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>

</main>


<script type="text/javascript">
    function confirmDelete() {
        event.preventDefault(); 
        var form = event.target.form; 
       
        Swal.fire({
            title: 'Yakin kategori dihapus ?',
            text: 'Kategori akan dihapus secara permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
    }
</script>
@endsection