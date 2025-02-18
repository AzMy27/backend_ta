@extends('layouts.app',['title'=>'Selamat Datang','description'=>'Di aplikasi Dai Bermasa'])
@section('content')
<style>
    #monthGraph {
        height: 225px !important; 
    }
    .dashboard-card {
        min-height: 200px;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 15px;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    
    .dashboard-card .card-body {
        padding: 2rem;
    }
    
    .dashboard-card .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
    }
    
    .number-display {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100px;
    }
    
    .counter {
        font-size: 3.5rem;
        font-weight: bold;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .dashboard-card {
            min-height: 150px;
        }
        
        .dashboard-card .card-body {
            padding: 1.5rem;
        }
        
        .counter {
            font-size: 2.5rem;
        }
        
        .number-display {
            height: 70px;
        }

    }
    </style>
<div class="row">
    @if(Auth::user()->isSuper())
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Total Kecamatan</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <div class="small text-white counter">{{$jumlah_kecamatan}}</div>
                
            </div>
        </div>
    </div>
    @endif
    @if(Auth::user()->isKecamatan() || Auth::user()->isSuper())
    <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">Total Desa</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <div class="small text-white counter">{{$jumlah_desa}}</div>
                
            </div>
        </div>
    </div>
    @endif
    <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body">Total Dai</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <div class="small text-white counter">{{$jumlah_dai}}</div>
                
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">Total Laporan</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <div class="small text-white counter">{{$jumlah_report}}</div>
                
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">Laporan Diperiksa</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <div class="small text-white counter">{{$jumlah_report_diterima}}</div>
                
            </div>
        </div>
    </div>
</div>
<div class="row">
        <div class="{{Auth::user()->isDesa()?'col-xl-12':'col-xl-6'}} ">
          <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
              <div>
                  <i class="fas fa-chart-bar me-1"></i>
                  Laporan Masuk (Tahun)
              </div>
                <div>
                    <select id="yearSelector" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-body">
                <canvas id="monthGraph"></canvas>
                <script>
                    const xValues = @json($chartLabels);
                    const yValues = @json($chartData);
                    const barColors = [
                        "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF",
                        "#FF9F40", "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0",
                        "#9966FF", "#FF9F40"
                    ];
                    
                    new Chart("monthGraph", {
                        type: "bar",
                        data: {
                            labels: xValues,
                            datasets: [{
                                backgroundColor: barColors,
                                data: yValues,
                                borderRadius: 5,  // Membuat bar menjadi rounded
                                maxBarThickness: 50,  // Membatasi ketebalan maksimal bar
                                minBarLength: 5  // Panjang minimal bar
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            legend: {display: false},
                            title: {
                                display: true,
                                text: "Laporan perbulan " + {{ $selectedYear }}
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        callback: function(value) {
                                            if (value % 1 === 0) {
                                                return value;
                                            }
                                        },
                                        stepSize: Math.ceil(Math.max(...yValues) / 10)  // Menyesuaikan interval berdasarkan data maksimal
                                    },
                                    gridLines: {
                                        drawBorder: false
                                    }
                                }],
                                xAxes: [{
                                    gridLines: {
                                        display: false
                                    }
                                }]
                            },
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 10,
                                    top: 0,
                                    bottom: 0
                                }
                            }
                        }
                    });
                    document.getElementById('yearSelector').addEventListener('change', function() {
                        window.location.href = '{{ route("dashboard") }}?year=' + this.value;
                    });
                </script>
            </div>
          </div>
        </div>

        @if (Auth::user()->isKecamatan())
        <div class="col-xl-6">
          <div class="card mb-4">
              <div class="card-header">
                  <i class="fas fa-chart-bar me-1"></i>
                  Laporan Masuk Kecamatan {{ $nama_kecamatan }} (Harian) 
              </div>
              <div class="card-body">
                <canvas id="myChartDay" style="width:100%;max-width:600px"></canvas>
                <script>
                    const xValuesDate = @json($dailyLabels);
                    const yValuesTotal = @json($dailyValues);
                    
                    new Chart("myChartDay", {
                        type: "line",
                        data: {
                            labels: xValuesDate,
                            datasets: [{
                                fill: false,
                                lineTension: 0,
                                backgroundColor: "rgba(0,0,255,1.0)",
                                borderColor: "rgba(0,0,255,0.1)",
                                data: yValuesTotal
                            }]
                        },
                        options: {
                            legend: {display: false},
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true,
                                        stepSize: 1
                                    }
                                }],
                            }
                        }
                    });
                </script>
            </div>
          </div>
        </div>
        @endif

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
                        <th>Tempat Tugas</th>
                        <th>Judul Kegiatan</th>
                        <th>Tipe Kegiatan</th>
                        <th>Target</th>
                        <th>Dikirim</th>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
        const target = +counter.innerText;
        const duration = 1000; 
        const increment = target / (duration / 16); 
        let current = 0;
        
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.innerText = Math.ceil(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.innerText = target;
            }
        };
        
        updateCounter();
    });
});
</script>
                