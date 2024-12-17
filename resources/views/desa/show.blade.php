@extends('layouts.app',['title'=>'Data Desa','description'=>'Melihat Desa'])
@section('content')
<div class="row mb-5 justify-content-center">
    <div class="col-6">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th class="bg-light">Nama Desa</th>
                        <td>{{$dataDesa->nama_desa}}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Kepala Desa</th>
                        <td>{{$dataDesa->nama_kepala}}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">No. Telp Desa</th>
                        <td>{{$dataDesa->no_telp_desa}}</td>
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
