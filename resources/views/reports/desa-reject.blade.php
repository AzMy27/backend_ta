@extends('layouts.app',['title'=>'Komentar Desa','description'=>'Berikan Komentar Penolakan'])
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Berikan Alasan Penolakan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.desa.comment.store', $report->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="comment" class="form-label">Komentar</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" 
                                      id="comment" 
                                      name="comment" 
                                      rows="5" 
                                      placeholder="Berikan alasan penolakan laporan"
                                      required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('reports.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-danger">Kirim Komentar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection