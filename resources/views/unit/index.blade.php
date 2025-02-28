@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-right">
                <a class="btn btn-primary" href="{{ route('unit.create') }}">Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table table-striped table-bordered no-wrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Unit</th>
                                <th>Kode Unit</th>
                                <th>Waktu Pembuatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready( function () {
        $('#table').DataTable({
            "autoWidth": true,
            "serverSide": true,
            "stateSave": true,
            "processing": true,
            "searchDelay": 400,
            "responsive" : true,
            ajax: '{{ route("unit.index") }}?ajax=true',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'nama_unit', name: 'nama_unit'},
                { data: 'kode_unit', name: 'kode_unit'},
                { data: 'created_at', name: 'created_at'},
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
        });
    } );
</script>
@endsection
