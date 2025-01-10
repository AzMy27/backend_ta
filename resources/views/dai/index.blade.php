@extends('layouts.app',['title'=>'Daftar Dai','description'=>'Melihat daftar dai'])
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        DAFTAR DAI
        <a href="{{route('dai.create')}}" class="btn btn-primary btn-sm float-end">Tambah</a>
    </div>
    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if($data->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada data dai yang tersedia</h5>
                <p class="text-muted">Data akan muncul setelah ditambahkan</p>
            </div>
        @else
        <table class="table table-striped table-bordered" id="datatablesSimple">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Domisili</th>
                    <th style="width: 2%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key=>$item)
                <tr >
                    <td>{{$key+1}}</td>
                    <td>{{$item->nik}}</td>
                    <td>{{$item->nama}}</td>
                    <td>{{$item->alamat}}</td>
                    <td>{{$item->desa->nama_desa}}, {{$item->desa->kecamatan->nama_kecamatan}}</td>
                    <td style="width: 1%">
                        <!-- Modal Konfirmasi -->
                        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteLabel">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus data ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteLabel">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus data ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group">
                            <a href="{{route('dai.show',$item->id)}}" class="btn btn-sm btn-success">
                                <i class="fa fa-eye"></i>Lihat
                            </a>
                            <a href="{{route('dai.edit',$item->id)}}" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i>Ubah
                            </a>
                            <form action="{{route('dai.destroy',$item->id)}}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach                       
            </tbody>
        </table>
        @endif
    </div>
</div>
@endsection