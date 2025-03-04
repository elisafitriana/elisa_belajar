@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h2>Detail Ticket</h2>
                @if(auth()->user()->role=='admin')
                <div>
                    <form action="{{ route('ticket.status', $ticket->id) }}" method="POST" onsubmit="return confirm('Are you sure to change status?')">
                        @csrf
                        @if($ticket->status=='open')
                        <button type="submit" name="status" value="waiting" class="btn btn-warning">Waiting</button>
                        <button type="submit" name="status" value="reject" class="btn btn-secondary">Reject</button>
                        @endif
                        @if($ticket->status=='waiting')
                        <button type="submit" name="status" value="close" class="btn btn-danger">Close</button>
                        @endif
                    </form>
                </div>
                @endif
            </div>
            <div >
            <table class="table">
                <tr>
                    <td width="20%">Judul</td>
                    <td>: {{ $ticket->title }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>: <span class="badge badge-{{ ['open'=>'success', 'close'=>'danger', 'waiting'=>'warning', 'reject'=>'secondary'][$ticket->status] }}">{{ $ticket->status }}</span></td>
                </tr>
                <tr>
                    <td>Prioritas</td>
                    <td>: <span class="badge badge-{{ ['low'=>'warning', 'medium'=>'danger', 'high' => 'danger'][$ticket->priority] }}">{{ $ticket->priority }}</span></td>
                </tr>
                <tr>
                    <td>Kategori</td>
                    <td>: {{ implode(', ',$ticket->categories->pluck('name')->toArray()) }}</td>
                </tr>
                <tr>
                    <td>File</td>
                    {{-- <td>: <a target="_blank" href="{{ Storage::url($ticket->file) }}">{{ $ticket->file }}</a></td> --}}
                    <td>: <a target="_blank" href="{{ url('/'.$ticket->file) }}">{{ $ticket->file }}</a></td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>: {!! $ticket->description !!}</td>
                </tr>
            </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>Komentar</h2>
            </div>
            <div class="py-1 card-body">
                @if((auth()->id()==$ticket->user_id || auth()->user()->role=='admin') && $ticket->status!='close')
                <form action="{{ route('ticket.comment', $ticket->id) }}" method="POST">
                    @csrf
                    <div class="py-3">
                        <label for="">Pesan Komentar</label>
                        <textarea name="comment" class="form-control" rows="5">{{ old('comment') }}</textarea>
                    </div>
                    <div class="py-3 text-right">
                        <button class="btn btn-primary">Post</button>
                    </div>
                </form>
                @endif
            </div>
        </div>
        @foreach ($ticket->comments as $comment)
        <div class="card">
            <div class="p-2 bg-white">
             <h4>{{ $comment->name }}</h4>
             <hr>
             <p>{{ $comment->comment }}</p>
             <hr>
             <p class="text-right">
                {{ $comment->created_at->diffForHumans() }}
             </p>
            </div>
         </div> 
        @endforeach
    </div>
</div>
@endsection