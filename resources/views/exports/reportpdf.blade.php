<!DOCTYPE html>
<html>
<head>
	<title>Report pdf</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT1MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		/* table tr td,
		table tr th{
			font-size: 9pt;
		} */
	</style>
    @php
    $months = [
        "01" => 'Januari',
        "01" => 'Februari',
        "03" => 'Maret',
        "04" => 'April',
        "05" => 'Mei',
        "06" => 'Juni',
        "07" => 'Juli',
        "08" => 'Agustus',
        "09" => 'September',
        "10" => 'Oktober',
        "11" => 'November',
        "11" => 'Desember'
    ];

    $selectedMonth = $month; // Example, replace with dynamic value
    @endphp
	<center>
        <img src="{{ public_path('/assets/images/big/rs.png') }}" height="100" style="width: auto; max-width: 100%">

		<h3>Laporan Bulanan Perintah Kerja Instalasi IT</h3><br>
        <div style=" width: 100%; height: 2px; background-color: black; margin: 10px 0;"></div>
		@if(in_array($selectedMonth, array_keys($months)))
            <p>Laporan Bulan {{ $months[$selectedMonth] ?? 'Semua'}} Tahun {{$year}} </p>
        @else

        @endif
	</center>
 
	<table>
		<thead>
			<tr>
				<th style="border: 1px solid black;"><b>Judul</b></th>
                <th style="border: 1px solid black;"><b>Deskripsi</b></th>
                <th style="border: 1px solid black;"><b>Status</b></th>
                <th style="border: 1px solid black;"><b>Level</b></th>
                <th style="border: 1px solid black;"><b>Tanggal Masuk</b></th>
                <th style="border: 1px solid black;"><b>Tanggal Keluar</b></th>
			</tr>
		</thead>
		<tbody>
			{{-- @php $i=1 @endphp --}}
			@foreach($tickets as $ticket)
			<tr style="border: 2px solid black;">
				<td style="border: 1px solid black;">{{ $ticket->title }}</td>
                <td style="border: 1px solid black;">{{ $ticket->description }}</td>
                <td style="border: 1px solid black;">{{ $ticket->status }}</td>
                <td style="border: 1px solid black;">{{ $ticket->priority}}</td>
                <td style="border: 1px solid black;">{{ $ticket->start_date ?? ''}}</td>
                <td style="border: 1px solid black;">{{ $ticket->end_date ?? ''}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
 
</body>
</html>