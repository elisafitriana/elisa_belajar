<table>
    <tr>
        <td> &nbsp;</td>
        <td> &nbsp;</td>
        <td colspan="2" style="text-align: center;">
            <img src="{{ public_path('/assets/images/big/rs.png') }}" height="100" style="width: auto; max-width: 100%">
        </td>
        {{-- <td colspan="3" align="center">
            <h4>Universitas Muhammadiyah Banjarmasin</h4>  <br>
            <i>Kampus Utama: Jl Gubernur Sarkawi, Barito Kuala, Kalimanatan Selatan</i> <br>
            <i>Kampus 1: Jl S.Parman (Komp. RUmah Sakit Islam Banjarmasin), Kalimanatan Selatan</i> <br>
            <i>Kampus 2: Jl S.Parman No 97, Banjarmasin, Kalimanatan Selatan</i> <br>
            <i>Telp/Fax: +62-511-748234, Email: info@umbmj.ac.id, Website: umbjm.ac.id</i> <br>
        </td> --}}
    </tr>
    <tr>
        <td colspan="4" align="center">
            <div style=" width: 100%; height: 3px; background-color: black; margin: 20px 0;"></div>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="4" style="text-align: center">
            <h4><b> Laporan Bulanan Perintah Kerja Instalasi IT</b> </h4>
        </td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        @php
        $months = [
            "01" => 'Januari',
            "02" => 'Februari',
            "03" => 'Maret',
            "04" => 'April',
            "05" => 'Mei',
            "06" => 'Juni',
            "07" => 'Juli',
            "08" => 'Agustus',
            "09" => 'September',
            "10" => 'Oktober',
            "11" => 'November',
            "12" => 'Desember'
        ];

        $selectedMonth = $month; // Example, replace with dynamic value
        @endphp
        <td colspan="4" style="text-align: center">
            @if(in_array($selectedMonth, array_keys($months)))
            <p>Bulan {{ $months[$selectedMonth] }}</p>
        @else

        @endif
        </td>
    </tr>
    <tr>
        <th></th>
        <th style="border: 2px solid black;"><b>Judul</b></th>
        <th style="border: 2px solid black;"><b>Deskripsi</b></th>
        <th style="border: 2px solid black;"><b>Status</b></th>
        <th style="border: 2px solid black;"><b>Level</b></th>
        <th style="border: 2px solid black;"><b>Tanggal Masuk</b></th>
        <th style="border: 2px solid black;"><b>Tanggal Keluar</b></th>
    </tr>
    @foreach($tickets as $ticket)
        <tr style="border: 2px solid black;">
            <td></td>
            <td style="border: 2px solid black;">{{ $ticket->title }}</td>
            <td style="border: 2px solid black;">{{ $ticket->description }}</td>
            <td style="border: 2px solid black;">{{ $ticket->status }}</td>
            <td style="border: 2px solid black;">{{ $ticket->priority}}</td>
            <td style="border: 2px solid black;">{{ $ticket->start_date ?? ''}}</td>
            <td style="border: 2px solid black;">{{ $ticket->end_date ?? ''}}</td>
        </tr>
    @endforeach
</table>
