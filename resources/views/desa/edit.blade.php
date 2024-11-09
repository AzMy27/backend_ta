@extends('layouts.app',['title'=>'Edit Desa','description'=>'Edit Data Desa'])
@section('content')
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Formulir Desa
                                <a href="{{route('desa.index')}}" class="btn btn-danger btn-sm float-end">Kembali</a>

                            </div>
                            <div class="card-body">
                                <form action="{{route('desa.update',$dataDesa->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="">Nama Desa</label>
                                        <input type="text" name="nama_desa" value="{{$dataDesa->nama_desa}}" class="form-control" placeholder="Masukkan Nama Desa">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama Kepala Desa</label>
                                        <input type="text" name="nama_kepala" value="{{$dataDesa->nama_kepala}}" class="form-control" placeholder="Masukkan Nama Kepala Desa">
                                    </div>       
                                    <div class="form-group">
                                        <label for="">No. HP Desa</label>
                                        <input type="text" name="no_telp_desa" value="{{$dataDesa->no_telp_desa}}" class="form-control" placeholder="Masukkan No. Hp Desa">
                                    </div>                             
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="text" name="email" value="{{$dataDesa->email}}" class="form-control" placeholder="Masukkan Email">
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
                