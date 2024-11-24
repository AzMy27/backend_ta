<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan - {{ $report->dai->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
            width: 30%;
        }
        .image-container {
            text-align: center;
            margin: 10px 0;
        }
        .image-container img {
            max-width: 300px;
            margin: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Kegiatan</h2>
        <p>Dai: {{ $report->dai->nama }}</p>
        <p>Tanggal: {{ date('d/m/Y') }}</p>
    </div>

    <table>
        <tr>
            <th>Kegiatan</th>
            <td>{{ $report->title }}</td>
        </tr>
        <tr>
            <th>Lokasi</th>
            <td>{{ $report->place }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ $report->date }}</td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td>{{ $report->description }}</td>
        </tr>
    </table>

    <div class="image-container">
        <h3>Dokumentasi Kegiatan</h3>
        <br>
        <br>
        <br>
        @foreach($images as $image)
            <img src="{{ public_path('storage/'.$image) }}" alt="Dokumentasi">
        @endforeach
    </div>

    <div class="footer">
        <p>Dokumen ini dibuat pada {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>