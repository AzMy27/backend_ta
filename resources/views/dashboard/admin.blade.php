@extends('layouts.app',['title'=>'Dashboard','description'=>'Beranda'])
@section('content')
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Total Laporan</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">{{$jumlah_report}}</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    {{-- <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">Laporan Masuk</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">.</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div> --}}
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">Total Dai</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">{{$jumlah_dai}}</a>
                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">Laporan Diterima</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">.</a>
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
                    Laporan Masuk Tahunan ({{$kecamatanName}})
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" style="width:100%;max-width:600px"></canvas>

                    <script>
                    const monthLabels = {!! $monthLabels !!};
                    const monthData = {!! $monthData !!};
                    const barColors = Array(monthLabels.length).fill('#4e73df');
                    
                    new Chart("monthlyChart", {
                        type: "bar",
                        data: {
                            labels: monthLabels,
                            datasets: [{
                                backgroundColor: barColors,
                                data: monthData
                            }]
                        },
                        options: {
                            responsive: true,
                            legend: {display: false},
                            title: {
                                display: true,
                                text: "Laporan Masuk Bulanan"
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        callback: function(value) {if (value % 1 === 0) {return value;}}
                                    }
                                }]
                            }
                        }
                    });
                    </script>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i>
                    Laporan Masuk Mingguan ({{$kecamatanName}})
                </div>
                <div class="card-body">
                    <canvas id="dailyChart" style="width:100%;max-width:600px"></canvas>

                    <script>
                    const dailyLabels = {!! $dailyLabels !!};
                    const dailyData = {!! $dailyData !!};

                    new Chart("dailyChart", {
                        type: "line",
                        data: {
                            labels: dailyLabels,
                            datasets: [{
                                fill: false,
                                lineTension: 0.3,
                                backgroundColor: "#1cc88a",
                                borderColor: "#1cc88a",
                                pointRadius: 3,
                                pointBackgroundColor: "#1cc88a",
                                pointBorderColor: "#1cc88a",
                                pointHoverRadius: 3,
                                pointHoverBackgroundColor: "#1cc88a",
                                pointHoverBorderColor: "#1cc88a",
                                pointHitRadius: 10,
                                pointBorderWidth: 2,
                                data: dailyData
                            }]
                        },
                        options: {
                            responsive: true,
                            legend: {display: false},
                            title: {
                                display: true,
                                text: "Laporan Masuk Harian"
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        callback: function(value) {if (value % 1 === 0) {return value;}}
                                    }
                                }]
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
                