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
                    <table id="zero_config" class="table table-striped table-bordered no-wrap">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>CreatedAt</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $key=>$cat)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $cat->name }}</td>
                                <td>{{ $cat->created_at }}</td>
                                <td class="d-flex">
                                    <a class="btn btn-sm btn-info" href="{{ route('category.edit', $cat->id) }}"><i class="fas fa-edit"></i></a>&nbsp;
                                    <form action="{{ route('category.destroy', $cat->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection