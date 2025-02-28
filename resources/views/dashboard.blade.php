@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card" style="padding: 20%">
            <h2>Selamat Datang {{ auth()->user()->name }}</h2>
        </div>
    </div>
</div>
@endsection
