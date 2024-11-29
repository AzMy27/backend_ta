@extends('layouts.app',['title'=>'Biodata Dai','description'=>'Melihat Biodata Dai'])
@section('content')
<div class="row mb-5 justify-content-center">
    <div class="col-6">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <div class="card-body d-flex flex-column align-items-center text-center">
                        <img src="{{'/storage/'.$data->foto_dai}}" alt="Foto Dai" class="rounded-circle mb-3" style="max-width: 150px; height: auto; object-fit: cover;">
                        <h3 class="card-title">{{$data->nama}}</h3>
                        <p class="card-text">{{$data->nik}}</p>
                    </div>
                    <tr>
                        <th class="bg-light">No. Hp</th>
                        <td>{{$data->no_hp}}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Tempat Lahir</th>
                        <td>{{$data->tempat_lahir}}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Tanggal Lahir</th>
                        <td>{{$data->tanggal_lahir}}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Alamat</th>
                        <td>{{$data->alamat}}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Pendidikan</th>
                        <td>{{$data->pendidikan_akhir}}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Status Kawin</th>
                        <td>{{$data->status_kawin}}</td>
                    </tr>
                </table>
            </div>  
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{route('desa.index')}}" class="btn btn-primary ">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
