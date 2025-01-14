@extends('layouts.app',['title'=>'Laporan','description'=>'Laporan Masuk'])
@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-table me-1"></i>
            Daftar Laporan
        </div>
        <div class="d-flex gap-3 align-items-center">
            <form action="{{route('reports.month')}}" id="monthSelect" method="GET" class="d-flex gap-2">
                <input type="month" 
                       name="date" 
                       class="form-control form-control-sm" 
                       value="{{ now()->format('Y-m') }}"
                       lang="id">
                <button type="submit" class="btn btn-sm {{ Request::routeIs('reports.month') ? 'btn-success' : 'btn-outline-success' }}">
                    <i class="fas fa-calendar-alt me-1"></i> Rekap
                </button>
            </form>
        </div>
    </div>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="card-body">
        <div class="table-responsive">
            @if($reports->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada laporan tersedia</h5>
                    <p class="text-muted">Laporan akan muncul setelah dai mengirim laporannya</p>
                </div>
            @else
                <table id="datatablesSimple" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Dai</th>
                            <th>Tempat Tugas</th>
                            <th>Judul Kegiatan</th>
                            <th>Dikirim</th>
                            <th>Status Desa</th>
                            {{-- @if (Auth::user()->isKecamatan()) --}}
                            <th>Status Kecamatan</th>
                            {{-- @endif --}}
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $key=>$item)                                            
                        <tr>
                            <td>{{$item->dai->nama}}</td>
                            <td>{{$item->dai->desa->nama_desa}}, {{$item->dai->desa->kecamatan->nama_kecamatan}}</td>
                            <td>{{$item->title}}</td>
                            <td>{{ \Carbon\Carbon::parse($item->updated_at)->format('d M Y H:i:s') }}</td>
                            <td>
                                @if ($item->validasi_desa === 'diterima')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($item->validasi_desa === 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning">Belum Diproses</span>
                                @endif
                            </td>
                            {{-- @if (Auth::user()->isKecamatan()) --}}
                                <td>
                                    @if ($item->validasi_kecamatan ==='diterima')
                                        <span class="badge bg-success">Diterima</span>
                                    @elseif($item->validasi_kecamatan === 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning">Belum Diproses</span>
                                    @endif
                                </td>
                            {{-- @endif --}}
                            <td>
                                <a href="{{route('reports.show',$item->id)}}" class="btn btn-success btn-sm">
                                    <i class="fas fa-eye me-1"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<style>
.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0,0,0,.125);
}

.btn-group .btn {
    padding: 0.375rem 1rem;
    font-size: 0.875rem;
}

.btn-outline-success:hover {
    color: #fff;
    background-color: #28a745;
    border-color: #28a745;
}

.btn-outline-warning:hover {
    color: #fff;
    background-color: #ffc107;
    border-color: #ffc107;
}

.table {
    margin-bottom: 0;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}

.search-box {
    max-width: 300px;
}

.form-select {
    background-color: #fff;
    border: 1px solid #ced4da;
}

.table-responsive {
    min-height: 400px;
}
</style>
@endsection