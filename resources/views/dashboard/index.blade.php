

@extends('layouts.app',['title'=>'Dashboard','description'=>'Beranda'])
@section('content')
<div class="row">
  @if(Auth::user()->isSuper())
  <div class="col-xl-3 col-md-6">
    <div class="card bg-primary text-white mb-4">
        <div class="card-body">Total Kecamatan</div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="#">{{$jumlah_kecamatan}}</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
  </div>
  @endif
  @if(Auth::user()->isKecamatan() || Auth::user()->isSuper())
  <div class="col-xl-3 col-md-6">
    <div class="card bg-primary text-white mb-4">
        <div class="card-body">Total Desa</div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="#">{{$jumlah_desa}}</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
  </div>
  @endif
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
    <div class="card bg-primary text-white mb-4">
        <div class="card-body">Total Laporan</div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="#">{{$jumlah_report}}</a>
            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
        </div>
    </div>
  </div>
    <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">Laporan Diterima</div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">{{$jumlah_report_diterima}}</a>
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
                    Laporan Masuk Tahun 
                </div>
                <div class="card-body">
                  <canvas id="monthGraph" style="width:100%;max-width:600px"></canvas>
                  <script>
                    const xValues = ["Januari", "Februari", "Maret", "April", "Mei"];
                    const yValues = [55, 49, 44, 24, 0];
                    const barColors = ["red", "green","blue","orange","brown"];
                    
                    new Chart("monthGraph", {
                      type: "bar",
                      data: {
                        labels: xValues,
                        datasets: [{
                          backgroundColor: barColors,
                          data: yValues
                        }]
                      },
                      options: {
                        legend: {display: false},
                        title: {
                          display: true,
                          text: "Laporan perbulan"
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
                  <i class="fas fa-chart-bar me-1"></i>
                  Laporan Masuk Harian 
              </div>
              <div class="card-body">
                <canvas id="myChartDay" style="width:100%;max-width:600px"></canvas>

                <script>
                const xValuesDate = [4,5,6,7,8,9,10];
                const yValuesTotal = [8,8,9,15,20,22,40];
                
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
                      yAxes: [{ticks: {min: 0, max:50}}],
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
                