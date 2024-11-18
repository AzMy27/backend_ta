@extends('layouts.app',['title'=>'Edit Dai','description'=>'Edit Data Dai'])
@section('content')

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Formulir DAI
                                <a href="{{route('dai.index')}}" class="btn btn-danger btn-sm float-end">Kembali</a>

                            </div>
                            <div class="card-body">
                                <form action="{{route('dai.update',$data->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="">NIK</label>
                                        <input type="text" value="{{$data->nik}}" name="nik" class="form-control" placeholder="Masukkan NIK">

                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" value="{{$data->nama}}" name="nama" class="form-control" placeholder="Masukkan Nama">
                                    </div>  
                                    <div class="form-group">
                                        <label for="">No. Hp</label>
                                        <input type="text" value="{{$data->no_hp}}" name="no_hp" class="form-control" placeholder="Masukkan Nama">
                                    </div>                                  
                                    <div class="form-group">
                                        <label for="">Tanggal Lahir</label>
                                        <input type="date" value="{{$data->tanggal_lahir}}" name="tanggal_lahir" class="form-control" >
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="">Tempat Lahir</label>
                                        <input type="text" value="{{$data->tempat_lahir}}" name="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir">

                                    </div>                                    
                                    <div class="form-group">
                                        <label for="">Alamat</label>
                                        <input type="text" value="{{$data->alamat}}" name="alamat" class="form-control" placeholder="Masukkan alamat">
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="">Pendidikan Akhir</label>
                                        <input type="text" value="{{$data->pendidikan_akhir}}" name="pendidikan_akhir" class="form-control" placeholder="Masukkan Pendidikan Akhir">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Status Kawin:</label>
                                        <br>
                                        <input type="radio" id="kawin" name="status_kawin" value="Sudah" {{ $data->status_kawin == 'Sudah' ? 'checked' : '' }}> Kawin
                                        <input type="radio" id="belum" name="status_kawin" value="Belum" {{ $data->status_kawin == 'Belum' ? 'checked' : '' }}> Belum Kawin
                                    </div>
                                    <div class="form-group">
                                        <label for="">Gambar</label>
                                        <input type="file" value="{{$data->gambar}}" name="foto_dai" class="form-control" >
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
                                        <button class="btn-primary btn btn-sm float-end">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
@endsection
                