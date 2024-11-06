@extends('layouts.app',['title'=>'Daftar Dai','description'=>'Melihat daftar dai'])
@section('content')
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                DAFTAR DAI
                                <a href="{{route('dai.create')}}" class="btn btn-primary btn-sm float-end">Tambah</a>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered" id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
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
                                            <td style="width: 1%">
                                                <div class="btn-group">
                                                    <a href="{{route('dai.show',$item->id)}}" class="btn btn-sm btn-success">Lihat</a>
                                                    <a href="{{route('dai.edit',$item->id)}}" class="btn btn-sm btn-warning">Edit</a>
                                                    <form action="{{route('dai.destroy',$item->id)}}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button href="#" class="btn btn-sm btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
@endsection
                