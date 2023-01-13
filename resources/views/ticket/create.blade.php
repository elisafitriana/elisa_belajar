@extends('layouts.app')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-8">
        <div class="card">
            <div class="card-header"><h2>Tambah Tiket</h2></div>
            <form action="{{ route('ticket.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="card-body">
                <div class="py-3">
                    <label for="">Judul</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror">
                    @error('title') 
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="py-3">
                    <label for="">Prioritas</label>
                    <select name="priority" class="form-control @error('title') is-invalid @enderror">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                    </select>
                    @error('priority') 
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="py-3">
                    <label for="">Category</label>
                    <select name="categories[]" class="form-control select2 @error('categories') is-invalid @enderror" multiple="multiple">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('categories') 
                    <div class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>
                <div class="py-3">
                    <label for="">File</label>
                    <input name="file_upload" type="file" class="form-control @error('file') is-invalid @enderror">
                    @error('file') 
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="py-3">
                    <label for="">Deskripsi</label>
                    <textarea name="description" id="desc" class="form-control  @error('description') is-invalid @enderror" rows="5">{{ old('description') }}</textarea>
                    @error('description') 
                    <div class="invalid-feedback">
                        <strong>{{ $message }}</strong>
                    </div>
                    @enderror
                </div>
                <div class="py-3 text-right">
                    <a href="{{ route('ticket.index') }}" class="btn btn-danger">Batal</a>
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.tiny.cloud/1/rned9w47mecy04m7po2djkl9ac29c70vulisd78jop50ic6h/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();

        tinymce.init({
        selector: '#desc',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount checklist mediaembed casechange export formatpainter pageembed linkchecker a11ychecker tinymcespellchecker permanentpen powerpaste advtable advcode editimage tinycomments tableofcontents footnotes mergetags autocorrect typography inlinecss',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
        tinycomments_mode: 'embedded',
        tinycomments_author: 'Author name',
        });
        });
</script>
@endsection