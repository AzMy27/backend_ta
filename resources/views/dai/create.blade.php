@extends('layouts.app',['title'=>'Tambah Dai','description'=>'Tambah Data Dai'])
@section('content')

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Formulir DAI
                                <a href="{{route('dai.index')}}" class="btn btn-danger btn-sm float-end">Kembali</a>

                            </div>
                            <div class="card-body">
                                <form action="{{route('dai.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">NIK</label>
                                        <input type="text" name="nik" class="form-control" placeholder="Masukkan NIK">

                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama">
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control" >
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir">

                                    </div>                                    
                                    <div class="form-group">
                                        <label for="">Alamat</label>
                                        <input type="text" name="alamat" class="form-control" placeholder="Masukkan alamat">
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="">Pendidikan Akhir</label>
                                        <input type="text" name="pendidikan_akhir" class="form-control" placeholder="Masukkan Pendidikan Akhir">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Status Kawin:</label>
                                        <br>
                                        <input type="radio" name="status_kawin" class="" placeholder="Masukkan Status Kawin" value="Sudah"> Kawin
                                        <input type="radio" name="status_kawin" class="" placeholder="Masukkan Status Kawin" value="Belum"> Belum Kawin
                                    </div>
                                    <div class="form-group">
                                        <label for="">Gambar</label>
                                        <input type="file" name="foto_dai" class="form-control" >
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
                                        <button class="btn-primary btn btn-sm float-end">Kirim</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
@endsection
                