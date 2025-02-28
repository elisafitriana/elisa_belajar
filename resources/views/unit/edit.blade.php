@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-8">
        <div class="card">
            <div class="card-header"><h2>Edit Kategori</h2></div>
            <form action="{{ route('unit.update', $unit->id) }}" method="POST">
                @method('PUT')
                @csrf
            <div class="card-body">
                <div class="py-3">
                    <label for="">Nama Unit</label>
                    <input type="text" name="nama_unit" value="{{ old('nama_unit') ?? $unit->nama_unit }}" class="form-control @error('nama_unit') is-invalid @enderror">
                    @error('nama_unit') 
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="py-3">
                    <label for="">Kode Unit</label>
                    <input type="text" name="kode_unit" value="{{ old('kode_unit') ?? $unit->kode_unit }}" class="form-control @error('kode_unit') is-invalid @enderror">
                    @error('kode_unit') 
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="py-3">
                    <label for="">Deskripsi</label>
                    <input type="text" name="deskripsi" value="{{ old('deskripsi') ?? $unit->deskripsi }}" class="form-control @error('deskripsi') is-invalid @enderror">
                    @error('deskripsi') 
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="py-3 text-right">
                    <a href="{{ route('unit.index') }}" class="btn btn-danger">Batal</a>
                    <button class="btn btn-primary">Update</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection