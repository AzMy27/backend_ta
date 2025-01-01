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
                                <th class="bg-light" style="width: 30%;">Tipe Kegiatan</th>
                                <td>{{$reports->type}}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Lokasi</th>
                                <td>{{$reports->place}}</td>
                            </tr>                            
                            <tr>
                                <th class="bg-light">Target</th>
                                <td>{{$reports->target}}</td>
                            </tr>                            
                            <tr>
                                <th class="bg-light">Tujuan</th>
                                <td>{{$reports->purpose}}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Tanggal</th>
                                <td>{{$reports->date}}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Koordinat</th>
                                <td>{{$reports->coordinate_point}}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Deskripsi</th>
                                <td>{{$reports->description}}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Koreksi Desa</th>
                                <td>{{$reports->koreksi_desa ?? 'Belum dikoreksi'}}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Koreksi Kecamatan</th>
                                <td>{{$reports->koreksi_kecamatan ?? 'Belum dikoreksi'}}</td>
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
                                                         style="width: 100%; height: 200px; object-fit: cover; cursor: pointer;"
                                                         data-bs-toggle="modal" 
                                                         data-bs-target="#imageModal"
                                                         onclick="showImage('{{asset('storage/'.$image) }}')">
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
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{route('reports.index')}}" class="btn btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <div>
                            @if (Auth::user()->isDesa() && $reports->validasi_desa == null)
                                <form action="{{route('reports.desa.approve',$reports->id)}}" method="POST" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin menerima laporan ini?')">
                                        <i class="fas fa-check me-2"></i>Terima
                                    </button>
                                </form>
                                <form action="{{route('reports.desa.reject',$reports->id)}}" method="post" style="display: inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak laporan ini?')">
                                        <i class="fas fa-times me-2"></i>Tolak
                                    </button>
                                </form>
                            @endif
                            @if (Auth::user()->isKecamatan() && $reports->validasi_kecamatan == null)
                                @if ($canValidateKecamatan)
                                    <form action="{{route('reports.kecamatan.approve',$reports->id)}}" method="POST" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin ingin menerima laporan ini?')">
                                            <i class="fas fa-check me-2"></i>Terima
                                        </button>
                                    </form>
                                    <form action="{{route('reports.kecamatan.reject',$reports->id)}}" method="post" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menolak laporan ini?')">
                                            <i class="fas fa-times me-2"></i>Tolak
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-warning" role="alert">
                                        Laporan belum disetujui oleh Desa
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection
<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Foto Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Foto Kegiatan" class="img-fluid">
                <p>Gambar diambil pada: {{$reports->created_at}}</p>
            </div>
        </div>
    </div>
</div>

<script>
    function showImage(imageUrl) {
        const modalImage = document.getElementById('modalImage');
        modalImage.src = imageUrl;
    }
</script>
