@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', [
'title' => isset($process) ? 'Edit Proses Pengurusan' : 'Tambah Proses Pengurusan'
])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h5 class="mb-0">{{ isset($process) ? 'Edit' : 'Tambah' }} Proses Pengurusan</h5>
                </div>
                <div class="card-body px-4 pt-3 pb-2">
                    <form action="{{ isset($process)
                                    ? route('pic_process.update', $process->id)
                                    : route('pic_process.store') }}" method="POST">
                        @csrf
                        @if(isset($process))
                        @method('PUT')
                        @endif

                        {{-- hidden input: pic_document_id agar prosesnya nyambung --}}
                        <input type="hidden" name="pic_document_id"
                            value="{{ old('pic_document_id', $process->pic_document_id ?? $picDocument->id ?? '') }}">

                        <div class="mb-3">
                            <label for="step_name" class="form-label text-sm">Nama Proses</label>
                            <input type="text" name="step_name" id="step_name" class="form-control"
                                value="{{ old('step_name', $process->step_name ?? '') }}">
                            @error('step_name')
                            <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="step_status" class="form-label text-sm">Status</label>
                            <select name="step_status" id="step_status" class="form-select">
                                <option value="">Pilih Status</option>
                                <option value="pending" {{ old('step_status', $process->step_status ?? '') == 'pending'
                                    ?
                                    'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="in_progress" {{ old('step_status', $process->step_status ?? '') ==
                                    'in_progress' ?
                                    'selected' : '' }}>
                                    In Progress
                                </option>
                                <option value="done" {{ old('step_status', $process->step_status ?? '') == 'done' ?
                                    'selected' :
                                    '' }}>
                                    Selesai
                                </option>
                            </select>
                            @error('status')
                            <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- step date --}}
                        <div class="mb-3">
                            <label for="step_date" class="form-label text-sm">Tanggal Proses</label>
                            <input type="datetime-local" name="step_date" id="step_date" class="form-control"
                                value="{{ old('step_date', isset($process->step_date) ? \Carbon\Carbon::parse($process->step_date)->format('Y-m-d\TH:i') : '') }}">
                            @error('step_date')
                            <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="note" class="form-label text-sm">Catatan</label>
                            <textarea name="note" id="note" class="form-control"
                                rows="3">{{ old('note', $process->note ?? '') }}</textarea>
                            @error('note')
                            <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('pic_process.index', ['pic_document_code' => request('pic_document_code')]) }}"
                                class="btn btn-secondary">
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($process) ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection