@extends('layouts.app')

@section('content')

<main class="content">
    <h1 class="h3 mb-3">{{ $pages }}</h1>
    <div class="container-fluid p-0">
        <div class="card p-3">
            <div class="card-body">
                <form action="{{ url('/profile-update') }}" method="post">
                    @csrf

                    <input type="hidden" name="id" value="{{ Auth::user()->id }}">

                    <label for="name" class="form-label">Username</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}"
                        class="form-control mb-3 @error('name') is-invalid @enderror">
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label for="name" class="form-label">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}"
                        class="form-control mb-3 @error('email') is-invalid @enderror">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <label for="name" class="form-label">New Password</label>
                    <input type="password" name="password"
                        class="form-control mb-3 @error('password') is-invalid @enderror">
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-primary mt-3">Simpan</button>

                </form>
            </div>
        </div>
    </div>

</main>

@endsection