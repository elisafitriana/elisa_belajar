@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-right">
                <a class="btn btn-primary" href="{{ route('category.create') }}">Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table table-striped table-bordered no-wrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>CreatedAt</th>
                                <th>Option</th>
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
            ajax: '{{ route("category.index") }}?ajax=true',
            columns: [
                { data: 'DT_RowIndex', name: 'id'},
                { data: 'name', name: 'name'},
                { data: 'created_at', name: 'created_at'},
                { data:  'id', width: 100, orderable: false, searchable: false, render:function(id){
                    const url = '{{ url()->current() }}'
                    return `
                    <div class="d-flex">
                    <a href="${url}/${id}/edit" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i>
                    </a>&nbsp;
                    <form action="${url}/${id}" method="POST" onsubmit="return confirm('Are you sure to delete?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                    <div>
                    `
                }},
            ],
        });
    } );
</script>
@endsection