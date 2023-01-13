<html>
    <body>
        <h2>Your ticket has been close</h2>
        <table>
            <tr>
                <td width="20%">Judul</td>
                <td>: {{ $ticket->title }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>: <span class="badge badge-{{ ['open'=>'success', 'close'=>'danger', 'waiting'=>'warning', 'reject'=>'secondary'][$ticket->status] }}">{{ $ticket->status }}</span></td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>: {!! $ticket->description !!}</td>
            </tr>
        </table>
    </body>
</html>