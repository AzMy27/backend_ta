@extends('layouts.app',['title'=>'Daftar Desa','description'=>'Melihat daftar Desa'])
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        DAFTAR Desa
        <a href="{{route('desa.create')}}" class="btn btn-primary btn-sm float-end">Tambah</a>
    </div>
    <div class="card-body">
        @if($dataDesa->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada data desa yang tersedia</h5>
                <p class="text-muted">Data akan muncul setelah ditambahkan</p>
            </div>
        @else
            <table class="table table-striped table-bordered" id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Desa</th>
                        <th>Kepala Desa</th>
                        <th>No. HP</th>
                        <th style="width: 2%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dataDesa as $key=>$item)
                    <tr >
                        <td>{{$key+1}}</td>
                        <td>{{$item->nama_desa}}</td>
                        <td>{{$item->nama_kepala}}</td>
                        <td>{{$item->no_telp_desa}}</td>
                        <td style="width: 1%">
                            <div class="btn-group">
                                <a href="{{route('desa.show',$item->id)}}" class="btn btn-sm btn-success">
                                    <i class="fas fa-eye me-1"></i> Lihat
                                </a>
                                <a href="{{route('desa.edit',$item->id)}}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit me-1"></i> Ubah
                                </a>
                                <form action="{{route('desa.destroy',$item->id)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button href="#" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash me-1"></i> Hapus
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
                