@extends('layouts.app',['title'=>'Daftar Kecamatan','description'=>'Melihat daftar Kecamatan'])
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        DAFTAR Kecamatan
        <a href="{{route('kecamatan.create')}}" class="btn btn-primary btn-sm float-end">Tambah</a>
    </div>
    <div class="card-body">
        <table class="table table-striped table-bordered" id="datatablesSimple">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kecamatan</th>
                    <th>Koordinator Camat</th>
                    <th>No. HP</th>
                    {{-- <th style="width: 2%">Aksi</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($dataKecamatan as $key=>$item)
                <tr >
                    <td>{{$key+1}}</td>
                    <td>{{$item->nama_kecamatan}}</td>
                    <td>{{$item->nama_koordinator}}</td>
                    <td>{{$item->no_telp_koordinator}}</td>
                    <td style="width: 1%">
                        {{-- <div class="btn-group">
                            <a href="{{route('desa.show',$item->id)}}" class="btn btn-sm btn-success">Lihat</a>
                            <a href="{{route('desa.edit',$item->id)}}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{route('desa.destroy',$item->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button href="#" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div> --}}
                    </td>
                </tr>
                @endforeach                       
            </tbody>
        </table>
    </div>
</div>
@endsection
                