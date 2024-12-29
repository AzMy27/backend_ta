<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Mingguan</title>
    <style>
        @page {
            margin: 0.5cm;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 1.5cm;
            position: relative;
            min-height: 100vh;
            padding-bottom: 60px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .subheader {
            margin: 15px 0;
            padding: 8px;
            background-color: #f8f9fa;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 12px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 6px;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .dai-info {
            margin-top: 15px;
            margin-bottom: 10px;
            padding: 8px;
            background-color: #f8f9fa;
            font-size: 14px;
        }
        .dai-info h3 {
            margin: 0;
            font-size: 16px;
        }
        .image-container {
            text-align: center;
            margin: 20px 0;
            width: 100%;
            clear: both;
            page-break-inside: avoid;
            min-height: 300px; /* Tambahkan minimum height */
        }
        .image-container h4 {
            margin: 30px 0 15px 0;
            clear: both;
            font-size: 14px;
            background-color: #f8f9fa;
            padding: 8px;
            border-radius: 4px;
        }
        
        .image-wrapper {
            display: inline-block;
            margin: 10px;
            vertical-align: top;
            width: 250px; /* Tetapkan lebar tetap */
        }
        
        .image-wrapper img {
            width: 100%; /* Gunakan lebar 100% dari wrapper */
            height: auto;
            max-height: 300px; /* Batasi tinggi maksimum */
            object-fit: contain; /* Pastikan gambar sesuai proporsi */
            margin: 5px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .footer {
            text-align: center;
            font-size: 10px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            padding: 10px 0;
            background-color: white;
        }
        .footer p {
            margin: 2px 0;
        }
        .page-break {
            page-break-after: always;
            clear: both;
        }
        .kecamatan-docs {
            margin-top: 30px;
        }
        .kecamatan-docs .image-container {
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>REKAP LAPORAN MINGGUAN</h2>
        @if($user->isDesa())
            <p>Desa: {{ $user->desa->nama_desa }}</p>
        @elseif($user->isKecamatan())
            <p>Kecamatan: {{ $user->kecamatan->nama_kecamatan }}</p>
        @endif
        <p>Periode: {{ $startDate->isoFormat('D MMMM Y') }} - {{ $endDate->isoFormat('D MMMM Y') }}</p>
    </div>
    @foreach($groupedReports as $daiId => $daiReports)
        @php $firstReport = $daiReports->first(); @endphp
        <div class="dai-info">
            <h3>DAI: {{ $firstReport->dai->nama }}</h3>
            <p>Desa: {{ $firstReport->dai->desa->nama_desa }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kegiatan</th>
                    <th>Tipe</th>
                    <th>Lokasi</th>
                    <th>Target</th>
                    <th>Tujuan</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($daiReports as $index => $report)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $report->date }}</td>
                        <td>{{ $report->title }}</td>
                        <td>{{ $report->type }}</td>
                        <td>{{ $report->place }}</td>
                        <td>{{ $report->target }}</td>
                        <td>{{ $report->purpose }}</td>
                        <td>{{ $report->description }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="page-break"></div>

        @foreach($daiReports as $report)
            @if($report->images)
                <div class="image-container">
                    <h4>Dokumentasi: {{ $report->title }}</h4>
                    @foreach(json_decode($report->images, true) as $image)
                        <div class="image-wrapper">
                            <img src="{{ public_path('storage/'.$image) }}" alt="Dokumentasi">
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
        <br><br><br>

    @endforeach
    <div class="footer">
        <p>Dokumen ini dibuat pada {{ now()->isoFormat('D MMMM Y HH:mm:ss') }}</p>
        <p>Oleh: {{ $user->name }}</p>
    </div>
</body>
</html>