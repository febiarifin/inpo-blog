@extends('layouts.app')

@section('content')
<main class="content">
    <h1 class="h3 mb-3">{{ $pages }}</h1>
    <div class="container-fluid p-0">
        <div class="card">
            <div class="card-body">
                <a href="post-create" class="btn btn-primary mb-3">
                    <span class="align-middle"> <i class="fa-solid fa-plus"></i> Buat
                        Artikel</span></a>

                <table class="table table-bordered">
                    <tr class="text-center">
                        <th>NO</th>
                        <th>JUDUL</th>
                        <th>PUBLISHED AT</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>

                    @foreach ($posts as $post)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>
                            @if ($post->status === 1)
                            <a href="{{ url('post/'.$post->user->name.'/'.$post->id.'/'.$post->slug) }}"
                                class="link-primary">{{ Str::substr($post->title,0,50)}}</a>
                            @else
                            <a href="{{ url('preview/'.$post->user->name.'/'.$post->id.'/'.$post->slug) }}"
                                class="link-primary">{{ Str::substr($post->title,0,50)}}</a>
                            @endif
                        </td>
                        <td>{{ $post->published_at }}</td>
                        <td>
                            @if ( $post->status == 1)
                            <span class="badge bg-success">Posting</span>
                            @elseif( $post->status == 0)
                            <span class="badge bg-secondary">Draft</span>
                            @else
                            <span class="badge bg-danger">BANNED</span>
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
                                        onclick="confirmEditStatusDraft()">Draft</button>
                                </form>
                                @elseif( $post->status == 0)
                                <form action="post-posting" method="post">
                                    @method('post')
                                    @csrf
                                    <input type="hidden" name="id" value="{{$post->id}}">
                                    <button class="btn btn-success btn-sm" type="submit"
                                        onclick="confirmEditStatusPosting()">Posting</button>
                                </form>
                                @endif

                                <form action="post-edit" method="post">
                                    @method('post')
                                    @csrf
                                    <input type="hidden" name="id" value="{{$post->id}}">
                                    <button class="btn btn-primary btn-sm" type="submit"><i
                                            class="fa-solid fa-pen-to-square"></i></button>
                                </form>

                                <form action="{{ url('post-delete') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $post->id }}">
                                    <button class="btn btn-danger btn-sm" type="submit" onclick="confirmDeletePost()">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>
    {{ $posts->links() }}
</main>

<script type="text/javascript">
    function confirmDeletePost() {
        event.preventDefault(); 
        var form = event.target.form; 
       
        Swal.fire({
            title: 'Yakin artikel dihapus ?',
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

    function confirmEditStatusPosting() {
        event.preventDefault(); 
        var form = event.target.form; 
       
        Swal.fire({
            title: 'Yakin posting artikel ?',
            text : 'Artikel akan ditampilkan pada halaman website',
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

    function confirmEditStatusDraft() {
        event.preventDefault(); 
        var form = event.target.form; 
       
        Swal.fire({
            title: 'Yakin draft artikel ?',
            text : 'Artikel akan dihilangkan pada halaman website',
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