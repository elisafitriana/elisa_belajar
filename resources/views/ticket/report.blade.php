@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-hover">
                    <div class="p-2 bg-primary text-center">
                        <h1 class="font-light text-white">{{ @$report['open'][0]->total??0 }}</h1>
                        <h6 class="text-white">Open</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-hover">
                    <div class="p-2 bg-success text-center">
                        <h1 class="font-light text-white">{{ @$report['close'][0]->total??0 }}</h1>
                        <h6 class="text-white">Close</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-hover">
                    <div class="p-2 bg-cyan text-center">
                        <h1 class="font-light text-white">{{ @$report['waiting'][0]->total??0 }}</h1>
                        <h6 class="text-white">Waiting</h6>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-hover">
                    <div class="p-2 bg-danger text-center">
                        <h1 class="font-light text-white">{{ @$report['reject'][0]->total??0 }}</h1>
                        <h6 class="text-white">Reject</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <input type="month" value="{{ $month }}" name="month" onchange="window.location.href='{{ url()->current() }}?month='+this.value">
                <div>
                    <a href="{{ url()->full() }}&export=true" target="_blank" class="btn btn-success"><i class="fas fa-file-excel"></i></a>
                </div>
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
                                <th>File</th>
                                <th>Created by</th>
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
            ajax: '{{ route("ticket.report") }}?ajax=true&month={{$month}}',
            columns: [
                { data: 'DT_RowIndex', name: 'id'},
                { data: 'title', name: 'title'},
                { data: 'status', name: 'status', render: function(status){
                    return `<badge class='badge badge-${ {open: 'success', close: 'danger', waiting: 'warning', reject: 'secondary'}[status] }'>${status}</badge>`
                }},
                { data: 'priority', name: 'priority'},
                { data: 'categories', name: 'categories', orderable: false, searchable: false},
                { data: 'file', name: 'file'},
                { data: 'name', name: 'name'}
            ],
        });
    } );
</script>
@endsection