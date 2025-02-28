<!DOCTYPE html>
<html>
<head>
    <title>Ticket Notification</title>
</head>
<body>
    <h1>Notifikasi Order Untuk {{ $tickets->name }}</h1>
    <ul>
        Ada Ticket baru masuk mohon untuk di proses dengan kendala sebagai berikut :
        <li>Judul: {{ $validated['title'] }}</li>
        <li>Deskripsi: {{ $validated['description'] ?? '' }}</li>
        <li>Level: {{ $validated['priority'] }}</li>
    </ul>
</body>
</html>
