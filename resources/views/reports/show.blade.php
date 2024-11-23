@extends('layouts.app',['title'=>'Laporan','description'=>'Melihat Laporan'])
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Laporan</h4>
                    <a href="{{ route('reports.download', $reports->id) }}" 
                       class="btn btn-primary">
                        <i class="fas fa-download me-2"></i>Download PDF
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th class="bg-light" style="width: 30%;">Kegiatan</th>
                                <td>{{$reports->title}}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Lokasi</th>
                                <td>{{$reports->place}}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Tanggal</th>
                                <td>{{$reports->date}}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Deskripsi</th>
                                <td>{{$reports->description}}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Gambar</th>
                                <td>
                                    @if($reports->images)
                                        <div class="row g-2">
                                            @foreach(json_decode($reports->images, true) as $image)
                                                <div class="col-md-6 col-lg-4">
                                                    <img src="{{ asset('storage/'.$image) }}" 
                                                         alt="Foto Kegiatan" 
                                                         class="img-fluid rounded" 
                                                         style="width: 100%; height: 200px; object-fit: cover;">
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">Tidak ada gambar</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="bg-light">Dibuat</th>
                                <td>{{$reports->created_at}}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Diperbarui</th>
                                <td>{{$reports->updated_at}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{route('reports.index')}}" class="btn btn-danger">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection