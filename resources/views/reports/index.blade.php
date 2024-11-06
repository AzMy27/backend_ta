@extends('layouts.app',['title'=>'Laporan','description'=>'Laporan Masuk'])
@section('content')

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Daftar Laporan
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Nama Dai</th>
                                            <th>Domisili</th>
                                            <th>Judul Kegiatan</th>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reports as $key=>$item)
                                            
                                        <tr>
                                            <td>{{$item->nama}}</td>
                                            <td>{{$item->alamat}}</td>
                                            <td>{{$item->title}}</td>
                                            <td>{{$item->date}}</td>
                                            <td>{{$item->updated_at}}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{route('reports.show',$item->id)}}" class="btn btn-sm btn-success">Lihat</a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
@endsection
                