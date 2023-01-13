@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-8">
        <div class="card">
            <div class="card-header"><h2>Edit User</h2></div>
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @method('PUT')
                @csrf
            <div class="card-body">
                <div class="py-3">
                    <label for="">Nama</label>
                    <input type="text" name="name" value="{{ old('name') ?? $user->name }}" class="form-control @error('name') is-invalid @enderror">
                    @error('name') 
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="py-3">
                    <label for="">Email</label>
                    <input type="text" name="email" value="{{ old('email') ?? $user->email }}" class="form-control @error('email') is-invalid @enderror">
                    @error('email') 
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="py-3">
                    <label for="">Password</label>
                    <input type="password" name="password"  class="form-control @error('password') is-invalid @enderror">
                    @error('password') 
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="py-3">
                    <label for="">Role</label>
                    <select name="role" class="form-control @error('role') is-invalid @enderror">
                        <option value="user" {{ $user->role=='user' ? 'selected' : ''}}>User</option>
                        <option value="admin" {{ $user->role=='admin' ? 'selected' : ''}}>Admin</option>
                    </select>
                    @error('role') 
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="py-3 text-right">
                    <a href="{{ route('user.index') }}" class="btn btn-danger">Batal</a>
                    <button class="btn btn-primary">Update</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection