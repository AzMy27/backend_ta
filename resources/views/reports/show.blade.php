@extends('layouts.app',['title'=>'Laporan','description'=>'Melihat Laporan'])
@section('content')
<div class="row mb-5 justify-content-center">
    <div class="col-6">
            <div class="card">
                <div class="card-body d-flex flex-column align-items-center text-center">
                    <img src="{{'/storage/'.$reports->laporan}}" alt="Foto Kegiatan" class="mb-3" style="max-width: 150px; height: auto; object-fit: cover;">
                    <h3 class="card-title">{{$reports->title}}</h3>
                    <p class="card-text">{{$reports->place}}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Tanggal Kegiatan </strong>{{ $reports->date }}
                    </li>
                    <li class="list-group-item"><strong>Deskripsi </strong>{{$reports->description}}</li>
                    <li class="list-group-item"><strong>Dibuat </strong>{{$reports->created_at}}</li>
                    <li class="list-group-item"><strong>Diperbarui </strong>{{$reports->updated_at}}</li>
                </ul>
                <a href="{{route('report.index')}}" class="btn btn-danger ">Kembali</a>
                
            </div>
    </div>
</div>
@endsection
