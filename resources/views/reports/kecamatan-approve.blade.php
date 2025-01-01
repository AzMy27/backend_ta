@extends('layouts.app',['title'=>'Komentar Penerimaan','description'=>'Form Komentar Penerimaan'])
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Komentar Saran Laporan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.kecamatan.approve.comment.post', $report->id) }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="comment" class="form-label">Komentar/Catatan</label>
                            <textarea name="comment" id="comment" rows="5" 
                                class="form-control @error('comment') is-invalid @enderror" 
                                placeholder="Masukkan komentar atau catatan untuk penerimaan laporan">{{ old('comment') }}</textarea>
                            @error('comment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('reports.show', $report->id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-2"></i>Simpan & Terima
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection