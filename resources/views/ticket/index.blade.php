@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header text-right">
                <a class="btn btn-primary" href="{{ route('ticket.create') }}">Tambah</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table" class="table table-striped table-bordered no-wrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Category</th>
                                <th>Unit</th>
                                {{-- <th>File</th> --}}
                                <th>Created by</th>
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
            ajax: '{{ route("ticket.index") }}?ajax=true',
            columns: [
                { data: 'DT_RowIndex', name: 'id'},
                { data: 'title', name: 'title'},
                { data: 'status', name: 'status', render: function(status){
                    return `<badge class='badge badge-${ {open: 'success', close: 'danger', waiting: 'warning', reject: 'secondary'}[status] }'>${status}</badge>`
                }},
                { data: 'priority', name: 'priority'},
                { data: 'categories', name: 'categories', orderable: false, searchable: false},
                { data: 'nama_unit', name: 'nama_unit'},
                // { data: 'file', name: 'file'},
                { data: 'name', name: 'name'},
                { data:  null, width: 100, orderable: false, searchable: false, render:function(data){
                    const url = '{{ url()->current() }}'
                    return `
                    <div class="d-flex">
                        <a href="${url}/${data.id}" class="btn btn-sm btn-warning">
                        <i class="fas fa-eye"></i>
                    </a>&nbsp;
                    ${data.status=='open'? `<a href="${url}/${data.id}/edit" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i>
                    </a>&nbsp;` : ''}
                    ${data.status=='open'? `<form action="${url}/${data.id}" method="POST" onsubmit="return confirm('Are you sure to delete?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                    <div>
                    `: ''}`
                }},
            ],
        });
    } );
</script>
@endsection