@extends('layouts.app')

@section('content')
<main class="content">
    <h1 class="h3 mb-3">{{ $pages }}</h1>
    <div class="container-fluid p-0">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tr class="text-center">
                        <th>NO</th>
                        <th>EMAIL</th>
                        <th>NAME</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>

                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            @if ($user->role == 0)
                            <span class="badge bg-success">ACTIVE</span>
                            @else
                            <span class="badge bg-danger">BANNED</span>
                            @endif
                        </td>
                        <td>
                            @if ($user->role == 0)
                            <form action="{{ url('user-banned') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <button class="btn btn-danger btn-sm" type="submit"
                                    onclick="confirmBanned()">BANNED</button>
                            </form>
                            @else
                            <form action="{{ url('user-activate') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <button class="btn btn-success btn-sm" type="submit"
                                    onclick="confirmActivate()">ACTIVATE</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach

                </table>
            </div>
        </div>
    </div>

    {{$users->links()}}
</main>


<script type="text/javascript">
    function confirmBanned() {
        event.preventDefault(); 
        var form = event.target.form; 
       
        Swal.fire({
            title: 'Yakin banned user ?',
            text: 'User akan dibanned dan semua artikelnya akan dinonaktifkan',
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

    function confirmActivate() {
        event.preventDefault(); 
        var form = event.target.form; 
       
        Swal.fire({
            title: 'Yakin activate user ?',
            text: 'User akan kembali diaktifkan',
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