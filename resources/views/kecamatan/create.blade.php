@extends('layouts.app',['title'=>'Tambah Kecamatan','description'=>'Tambah Data Kecamatan'])
@section('content')
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Formulir Kecamatan
                                <a href="{{route('kecamatan.index')}}" class="btn btn-danger btn-sm float-end">Kembali</a>

                            </div>
                            <div class="card-body">
                                <form action="{{route('kecamatan.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Kecamatan</label>
                                        <input type="text" name="nama_kecamatan" class="form-control" placeholder="Masukkan Nama Kecamatan">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama Koordinator</label>
                                        <input type="text" name="nama_koordinator" class="form-control" placeholder="Masukkan Nama Koordinator">
                                    </div>       
                                    <div class="form-group">
                                        <label for="">No. HP Koordinator</label>
                                        <input type="text" name="no_telp_koordinator" class="form-control" placeholder="Masukkan No. Hp Koordinator">
                                    </div>                             

                                    <br>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Masukkan Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="text" name="password" class="form-control" placeholder="Masukkan Password">
                                    </div>
                                    <br>
                                    <div class="form-grup" >
                                        <button class="btn-primary btn btn-sm float-end">Tambah</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
@endsection
                