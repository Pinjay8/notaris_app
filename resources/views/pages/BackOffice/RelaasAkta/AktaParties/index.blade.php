@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Pihak-Pihak Relaas'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Pihak Akta</h6>
            </div>
            <div class="card-body pt-1">

                {{-- Form Pencarian --}}
                <form method="GET" action="{{ route('relaas-parties.index') }}" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Masukkan Kode Registrasi"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                    </div>
                </form>

                {{-- Jika ada data relaas --}}
                @if($relaasInfo)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0 text-white">Detail Relaas</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p><strong>Kode Registrasi</strong></p>
                                <p class="text-muted">{{ $relaasInfo->registration_code }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Notaris</strong></p>
                                <p class="text-muted">{{ $relaasInfo->notaris->display_name ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Client</strong></p>
                                <p class="text-muted">{{ $relaasInfo->client->fullname ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-end mb-2">
                        <a href="{{ route('relaas-parties.create', $relaasInfo->id) }}" class="btn btn-primary btn-sm">+
                            Tambah Pihak Relaas</a>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Peran</th>
                                <th>Alamat</th>
                                <th>No Identitas</th>
                                <th>Jenis ID</th>
                                <th>Catatan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($parties as $party)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $party->name }}</td>
                                <td>{{ $party->role }}</td>
                                <td>{{ $party->address ?? '-' }}</td>
                                <td>{{ $party->id_number ?? '-' }}</td>
                                <td>{{ $party->id_type ?? '-' }}</td>
                                <td>{{ $party->note ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('relaas-parties.edit', [$relaasInfo->id, $party->id]) }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('relaas-parties.destroy', $party->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus pihak ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada pihak</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-center text-muted">Silakan cari kode registrasi terlebih dahulu.</p>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection