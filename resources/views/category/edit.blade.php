@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-8">
        <div class="card">
            <div class="card-header"><h2>Edit Kategori</h2></div>
            <form action="{{ route('category.update', $category->id) }}" method="POST">
                @csrf
            <div class="card-body">
                <div class="py-3">
                    <label for="">Nama</label>
                    <input type="text" name="name" value="{{ old('name') ?? $category->id }}" class="form-control @error('name') is-invalid @enderror">
                    @error('name') 
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="py-3 text-right">
                    <a href="{{ route('category.index') }}" class="btn btn-danger">Batal</a>
                    <button class="btn btn-primary">Update</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection