@extends('layouts.app',['title'=>'Laporan','description'=>'Laporan Masuk'])
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Daftar Laporan
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>Nama Dai</th>
                    <th>Domisili</th>
                    <th>Judul Kegiatan</th>
                    <th>Tanggal</th>
                    <th>Status Desa</th>
                    @if (Auth::user()->isKecamatan())
                        <th>Status Kecamatan</th>
                    @endif
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $key=>$item)                                            
                <tr>
                    <td>{{$item->dai->nama}}</td>
                    <td>{{$item->dai->desa->nama_desa}}, {{$item->dai->desa->kecamatan->nama_kecamatan}}</td>
                    <td>{{$item->title}}</td>
                    <td>{{$item->updated_at}}</td>
                    <td>
                        @if ($item->validasi_desa === 'diterima')
                            <span class="badge bg-success">Diterima</span>
                        @elseif($item->validasi_desa === 'ditolak')
                            <span class="badge bg-danger">Ditolak</span>
                        @else
                            <span class="badge bg-warning">Belum Diproses</span>
                        @endif
                    </td>
                    @if (Auth::user()->isKecamatan())
                        <td>
                            @if ($item->validasi_kecamatan ==='diterima')
                                <span class="badge bg-success">Diterima</span>
                            @elseif($item->validasi_kecamatan === 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-warning">Belum Diproses</span>
                            @endif
                        </td>
                    @endif

                    <td>
                        <div class="btn-group">
                            <a href="{{route('reports.show',$item->id)}}" class="btn btn-sm btn-success">Lihat</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
                