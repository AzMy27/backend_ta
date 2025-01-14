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
                    <th>Tempat Tugas</th>
                    <th style="width: 2%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key=>$item)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{ substr($item->nik, 0, 4) . str_repeat('x', strlen($item->nik) - 4) }}</td>
                    <td>{{$item->nama}}</td>
                    <td>{{$item->alamat}}</td>
                    <td>{{$item->desa->nama_desa}}, {{$item->desa->kecamatan->nama_kecamatan}}</td>
                    <td style="width: 1%">
                        <div class="btn-group">
                            <a href="{{route('dai.show',$item->id)}}" class="btn btn-success d-block mb-1">
                                <i class="fa fa-eye"></i> Lihat
                            </a>
                            <a href="{{route('dai.edit',$item->id)}}" class="btn btn-warning d-block mb-1">
                                <i class="fa fa-edit"></i> Ubah
                            </a>
                            <form action="{{route('dai.destroy',$item->id)}}" method="POST" id="delete-form-{{$item->id}}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger d-block" onclick="confirmDelete({{$item->id}})">
                                    <i class="fa fa-trash"></i> Hapus
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