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
                                    @if (Auth::user()->level == 'kecamatan')
                                    <div class="form-group">
                                        <label for="desa_id">Pilih Desa</label>
                                        <select name="desa_id" id="desa_id" class="form-control">
                                            @foreach ($desaList as $desa)
                                                <option value="{{ $desa->id }}">{{ $desa->nama_desa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label for="">NIK</label>
                                        <input type="text" name="nik" class="form-control" placeholder="Masukkan NIK">
                                        @error('nik')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama">
                                        @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror                                        
                                    </div>       
                                    <div class="form-group">
                                        <label for="">No. HP</label>
                                        <input type="text" name="no_hp" class="form-control" placeholder="Masukkan No. Hp">
                                        @error('no_hp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" class="form-control" placeholder="Masukkan Tempat Lahir">
                                        @error('tempat_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> 
                                    <div class="form-group">
                                        <label for="">Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control" max="{{date('Y-m-d')}}">
                                        @error('tanggal_lahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>                                    
                                    <div class="form-group">
                                        <label for="">Alamat</label>
                                        <input type="text" name="alamat" class="form-control" placeholder="Masukkan alamat">
                                        @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">RT</label>
                                        <input type="text" name="rt" class="form-control" placeholder="Masukkan RT">
                                        @error('rt')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">RW</label>
                                        <input type="text" name="rw" class="form-control" placeholder="Masukkan RW">
                                        @error('rw')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> 
                                    <div class="form-group">
                                        <label for="pendidikan_akhir">Pendidikan Akhir</label>
                                        <select name="pendidikan_akhir" id="pendidikan_akhir" class="form-control">
                                            <option value="" disabled selected>Pilih Pendidikan Akhir</option>
                                            <option value="SMP">SMP</option>
                                            <option value="SMA">SMA</option>
                                            <option value="MAN">MAN</option>
                                            <option value="D3">D3</option>
                                            <option value="D4/S1">D4/S1</option>
                                            <option value="S2">S2</option>
                                        </select>
                                        @error('pendidikan_akhir')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Status Kawin:</label>
                                        <br>
                                        <input type="radio" name="status_kawin" class="" placeholder="Masukkan Status Kawin" value="Sudah"> Kawin
                                        <input type="radio" name="status_kawin" class="" placeholder="Masukkan Status Kawin" value="Belum"> Belum Kawin
                                        @error('status_kawin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Gambar</label>
                                        <input type="file" name="foto_dai" class="form-control" >
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label for="">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Masukkan Email">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="">Password</label>
                                        <input type="text" name="password" class="form-control" placeholder="Masukkan Password">
                                        @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                