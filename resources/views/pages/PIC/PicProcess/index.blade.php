@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'PIC Proses Pengurusan'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            {{-- Card Utama --}}
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0">Daftar Proses Pengurusan</h5>
                    @if(request('pic_document_code'))
                    <a href="{{ route('pic_process.create', ['pic_document_code' => request('pic_document_code')]) }}"
                        class="btn btn-sm btn-primary mb-0">
                        + Tambah Proses
                    </a>
                    @endif
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">

                        {{-- Form Search --}}
                        <form method="GET" action="{{ route('pic_process.index') }}"
                            class="d-flex gap-2 ms-auto me-4 mb-3" style="max-width: 500px;">
                            <input type="text" name="pic_document_code" class="form-control form-control-sm"
                                placeholder="Cari PIC Document Code..." value="{{ request('pic_document_code') }}">
                            <button class="btn btn-sm btn-primary mb-0" type="submit">Cari</button>
                        </form>

                        @if(request('pic_document_code'))
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Nama Proses</th>
                                    <th>Status</th>
                                    <th>Tanggal Proses</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($processes as $process)
                                <tr class="text-center text-sm">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $process->step_name }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $process->step_status == 'done' ? 'success' : 'warning' }}">
                                            {{ ucfirst($process->step_status) }}
                                        </span>

                                    </td>
                                    {{-- step date datetime --}}
                                    <td>{{ $process->step_date }}</td>
                                    <td class="text-start">{{ $process->note ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('pic_process.edit', $process->id) }}"
                                            class="btn btn-sm btn-info mb-0">Edit</a>
                                        <form action="{{ route('pic_process.destroy', $process->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger mb-0"
                                                onclick="return confirm('Yakin hapus proses ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted text-sm">
                                        Belum ada proses pengurusan untuk PIC Document ini.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @else
                        <div class="text-center text-muted text-sm p-4">
                            Masukkan PIC Document Code untuk melihat daftar proses pengurusan.
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection