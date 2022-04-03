@extends('layouts.app')

@section('content')
<main class="content">
    <h1 class="h3 mb-3">{{ $pages }}</h1>
    <div class="container-fluid p-0">
        <div class="card">
            <div class="card-body">
                <a href="post-create" class="btn btn-primary mb-3">
                    <i class="align-middle" data-feather="plus"></i> <span class="align-middle">Buat
                        Artikel</span></a>

                <table class="table table-bordered">
                    <tr class="text-center">
                        <th>NO</th>
                        <th>JUDUL</th>
                        <th>KONTEN</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>

                    @foreach ($posts as $post)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ Str::substr($post->title,0,30)}}...</td>
                        <td>{{ Str::substr($post->content,0,50)}}...</td>
                        <td>
                            @if ( $post->status == 1)
                            <span class="badge bg-success">Posting</span>
                            @else
                            <span class="badge bg-secondary">Draft</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                @if ( $post->status == 1)
                                <form action="post-draft" method="post">
                                    @method('post')
                                    @csrf
                                    <input type="hidden" name="id" value="{{$post->id}}">
                                    <button class="btn btn-secondary btn-sm" type="submit"
                                        onclick="confirmEditStatus()">Draft</button>
                                </form>
                                @else
                                <form action="post-posting" method="post">
                                    @method('post')
                                    @csrf
                                    <input type="hidden" name="id" value="{{$post->id}}">
                                    <button class="btn btn-success btn-sm" type="submit"
                                        onclick="confirmEditStatus()">Posting</button>
                                </form>
                                @endif

                                <form action="post-edit" method="post">
                                    @method('post')
                                    @csrf
                                    <input type="hidden" name="id" value="{{$post->id}}">
                                    <button class="btn btn-primary btn-sm" type="submit">Edit</button>
                                </form>

                                <form action="post-delete" method="post">
                                    @method('post')
                                    @csrf
                                    <input type="hidden" name="id" value="{{$post->id}}">
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
            title: 'Yakin ingin menghapus artikel ?',
            text: 'Artikel akan dihapus secara permanen',
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

    function confirmEditStatus() {
        event.preventDefault(); 
        var form = event.target.form; 
       
        Swal.fire({
            title: 'Yakin ingin mengganti status artikel ?',
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