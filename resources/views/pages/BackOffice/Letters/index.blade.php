@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Surat Keluar'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4">
                <h6 class="mb-0">Surat Keluar</h6>
                <a href="{{ route('notary-letters.create') }}" class="btn btn-primary btn-sm mb-0">
                    + Tambah Surat Keluar
                </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <form method="GET" action="{{ route('notary-letters.index') }}"
                        class="d-flex gap-2 ms-auto me-4 mb-3" style="max-width: 300px;" class="no-spinner">
                        <input type="text" name="search" placeholder="Cari nomor surat..."
                            value="{{ request('search') }}" class="form-control">
                        <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                    </form>
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="th-title">No</th>
                                <th class="th-title">Nomor Surat</th>
                                <th class="th-title">Jenis</th>
                                <th class="th-title">Penerima</th>
                                <th class="th-title">Subjek</th>
                                <th class="th-title">Tanggal</th>
                                <th class="th-title">Lampiran</th>
                                <th class="th-title">File</th>
                                <th class="th-title">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($notaryLetters as $letter)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $letter->letter_number }}</td>
                                <td class="text-center">{{ $letter->type ?? '-' }}</td>
                                <td class="text-center">{{ $letter->recipient ?? '-' }}</td>
                                <td class="text-center">{{ $letter->subject ?? '-' }}</td>
                                <td class="text-center">{{ $letter->date ?
                                    \Carbon\Carbon::parse($letter->date)->format('d-m-Y') : '-' }}</td>
                                <td class="text-center">{{ $letter->attachment ?? '-' }}</td>
                                <td class="text-center">
                                    @if($letter->file_path)
                                    <a href="{{ asset('storage/'.$letter->file_path) }}" target="_blank"
                                        class="btn btn-info btn-sm mb-0">Lihat File</a>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('notary-letters.edit', $letter->id) }}"
                                        class="btn btn-warning btn-sm mb-0">Edit</a>
                                    <form action="{{ route('notary-letters.destroy', $letter->id) }}" method="POST"
                                        class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm mb-0"
                                            onclick="return confirm('Yakin ingin menghapus surat ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted text-sm">Belum ada data surat keluar.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection