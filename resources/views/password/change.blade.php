@extends('layouts.app',['title'=>'Ganti Password','description'=>'Ganti Password'])
@section('content')
<div class="card shadow-lg border-0 rounded-lg mt-5">
    <div class="card-header">
        <h3 class="text-center font-weight-light my-4">Ganti Password</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('password.confirmed') }}" method="POST">
            @csrf
            @if (session()->has('warning'))
                <div class="alert alert-warning">
                    {{ session()->get('warning') }}
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif

            <div class="form-floating mb-3">
                <input class="form-control @error('old_password') is-invalid @enderror" 
                    id="oldPassword" 
                    type="password" 
                    name="old_password" 
                    placeholder="Password Lama" />
                <label for="oldPassword">Password Lama</label>
                @error('old_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input class="form-control @error('new_password') is-invalid @enderror" 
                    id="newPassword" 
                    type="password" 
                    name="new_password" 
                    placeholder="Password Baru" />
                <label for="newPassword">Password Baru</label>
                @error('new_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-floating mb-3">
                <input class="form-control" 
                    id="newPasswordConfirmation" 
                    type="password" 
                    name="new_password_confirmation" 
                    placeholder="Konfirmasi Password Baru" />
                <label for="newPasswordConfirmation">Konfirmasi Password Baru</label>
            </div>

            <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                <button type="submit" class="btn btn-primary">Ganti Password</button>
            </div>
        </form>
    </div>
</div>
@endsection