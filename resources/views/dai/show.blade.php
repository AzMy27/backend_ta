@extends('layouts.app',['title'=>'Biodata Dai','description'=>'Melihat Biodata Dai'])
@section('content')
<div class="row mb-5 justify-content-center">
    <div class="col-6">
            <div class="card">
                <div class="card-body d-flex flex-column align-items-center text-center">
                    <img src="{{'/storage/'.$data->foto_dai}}" alt="Foto Dai" class="rounded-circle mb-3" style="max-width: 150px; height: auto; object-fit: cover;">
                    <h3 class="card-title">{{$data->nama}}</h3>
                    <p class="card-text">{{$data->nik}}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>No. Hp: </strong>{{$data->no_hp}}</li>
                    <li class="list-group-item">
                        <strong>Tempat Lahir: </strong>{{ $data->tempat_lahir }}
                    </li>
                    <li class="list-group-item"><strong>Tanggal Lahir: </strong>{{$data->tanggal_lahir}}</li>
                    <li class="list-group-item"><strong>Alamat: </strong>{{$data->alamat}}</li>
                    <li class="list-group-item"><strong>Pendidikan Akhir: </strong>{{$data->pendidikan_akhir}}</li>
                    <li class="list-group-item"><strong>Status Kawin: </strong>{{$data->status_kawin}}</li>
                </ul>
                <a href="{{route('dai.index')}}" class="btn btn-danger ">Kembali</a>
                
            </div>
    </div>
</div>
@endsection
