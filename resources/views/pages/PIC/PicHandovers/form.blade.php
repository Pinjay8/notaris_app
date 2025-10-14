@extends('layouts.app')

@section('title', 'Serah Terima Dokumen')


@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Serah Terima Dokumen'])

<div class="row mt-4 mx-4">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-header pb-0">
                <h5>Form Serah Terima Dokumen</h5>
            </div>
            <hr>
            <div class="card-body">
                <form method="POST" action="{{ route('pic_handovers.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-sm">Pilih Dokumen</label>
                        <select name="pic_document_id" class="form-select">
                            @foreach ($picDocuments as $doc)
                            <option value="{{ $doc->id }}">{{ $doc->pic_document_code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-sm">Tanggal Serah Terima</label>
                        <input type="date" name="handover_date" class="form-control"
                            value="{{ old('handover_date', now()->toDateString()) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-sm">Nama Penerima</label>
                        <input type="text" name="recipient_name" class="form-control"
                            value="{{ old('recipient_name') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-sm">Kontak Penerima</label>
                        <input type="text" name="recipient_contact" class="form-control"
                            value="{{ old('recipient_contact') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-sm">Catatan</label>
                        <textarea name="note" class="form-control">{{ old('note') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-sm">File (Opsional)</label>
                        <input type="file" name="file_path" class="form-control">
                    </div>

                    <a href="{{ route('pic_handovers.index') }}" class="btn btn-secondary">Kembali</a>
                    <button class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection