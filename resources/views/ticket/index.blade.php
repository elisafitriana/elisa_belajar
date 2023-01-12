@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-hover">
                            <div class="p-2 bg-primary text-center">
                                <h1 class="font-light text-white">2,064</h1>
                                <h6 class="text-white">Total Tickets</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-hover">
                            <div class="p-2 bg-cyan text-center">
                                <h1 class="font-light text-white">1,738</h1>
                                <h6 class="text-white">Responded</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-hover">
                            <div class="p-2 bg-success text-center">
                                <h1 class="font-light text-white">1100</h1>
                                <h6 class="text-white">Resolve</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-6 col-lg-3 col-xlg-3">
                        <div class="card card-hover">
                            <div class="p-2 bg-danger text-center">
                                <h1 class="font-light text-white">964</h1>
                                <h6 class="text-white">Pending</h6>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered no-wrap">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Title</th>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Created by</th>
                                <th>Date</th>
                                <th>Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge badge-light-warning">In Progress</span></td>
                                <td><a href="javascript:void(0)" class="font-weight-medium link">Elegant
                                        Theme
                                        Side Menu Open OnClick</a></td>
                                <td><a href="javascript:void(0)" class="font-bold link">276377</a></td>
                                <td>Elegant Admin</td>
                                <td>Eric Pratt</td>
                                <td>2018/05/01</td>
                                <td>Fazz</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection