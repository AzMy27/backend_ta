@extends('layouts.app',['title'=>'Dashboard','description'=>'Beranda'])
@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Warna Biru</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">Warna Kuning</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">Warna Hijau</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">Warna Merah</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">View Details</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-1"></i>
                    Laporan Kecamatan 
                    @if ($kecamatanName)
                        {{$kecamatanName}}
                    @endif
                </div>
                <div class="card-body">
                    <canvas id="myChart" style="width:100%;max-width:600px"></canvas>
                    <script>
                        const monthlyData = @json($monthlyReports);
                        
                        const labels = monthlyData.map(item => `${item.month_name} ${item.year}`);
                        const totals = monthlyData.map(item => item.total);
                        const totalDai = monthlyData.map(item => item.total_dai);
                        
                        new Chart("myChart", {
                            type: "bar",
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: 'Laporan Masuk',
                                    backgroundColor: "rgba(0, 123, 255, 0.5)",
                                    borderColor: "rgba(0, 123, 255, 1)",
                                    borderWidth: 1,
                                    data: totals
                                },]
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                },
                                plugins: {
                                    title: {
                                        display: true,
                                        text: 'Rekap Laporan Bulanan'
                                    },
                                    legend: {
                                        display: true
                                    }
                                }
                            }
                        });
                        </script>
                </div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Laporan Masuk
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Domisili</th>
                        <th>Judul Kegiatan</th>
                        <th>Tipe Kegiatan</th>
                        <th>Target</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $key=>$item)
                    <tr>
                        <td>{{$item->dai->nama}}</td>
                        <td>{{$item->dai->desa->nama_desa}}, {{$item->dai->desa->kecamatan->nama_kecamatan}}</td>
                        <td>{{$item->title}}</td>
                        <td>{{$item->type}}</td>
                        <td>{{$item->target}}</td>
                        <td>{{$item->updated_at}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
                