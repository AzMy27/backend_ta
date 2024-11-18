@extends('layouts.app',['title'=>'Data Desa','description'=>'Melihat Desa'])
@section('content')
<div class="row mb-5 justify-content-center">
    <div class="col-6">
            <div class="card">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Desa: </strong>{{$dataDesa->nama_desa}}</li>
                    <li class="list-group-item"><strong>Kepala Desa: </strong>{{$dataDesa->nama_kepala}}</li>
                    <li class="list-group-item"><strong>Telepon: </strong>{{$dataDesa->no_telp_desa}}</li>

                </ul>
                <a href="{{route('desa.index')}}" class="btn btn-danger ">Kembali</a>
                
            </div>
    </div>
</div>
@endsection
