@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Pihak-Pihak Akta'])

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center mb-0 pb-0">
                <h6>Pihak-Pihak Akta</h6>
            </div>
            <div class="card-body">

                {{-- Form Pencarian --}}
                <form method="GET" action="{{ route('akta-parties.index') }}" class="mb-3" class="no-spinner">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Masukkan Kode Registrasi atau Nomor Akta" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                    </div>
                </form>

                {{-- Jika ada transaksi ditemukan --}}
                @if($aktaInfo && $aktaInfo->count() > 0)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0 text-white">Detail Akta</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Kode Registrasi</strong></p>
                                <p class="text-muted">{{ $aktaInfo->first()->registration_code }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Nomor Akta</strong></p>
                                <p class="text-muted">{{ $aktaInfo->first()->akta_number ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Jenis Akta</strong></p>
                                <p class="text-muted">{{ $aktaInfo->first()->akta_type->type ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Notaris</strong></p>
                                <p class="text-muted">{{ $aktaInfo->first()->notaris->display_name ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Client</strong></p>
                                <p class="text-muted">{{ $aktaInfo->first()->client->fullname ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Status</strong></p>
                                <span class="badge
                                    @switch($aktaInfo->first()->status)
                                        @case('draft') bg-secondary @break
                                        @case('diproses') bg-warning @break
                                        @case('selesai') bg-success @break
                                        @case('dibatalkan') bg-danger @break
                                        @default bg-light text-dark
                                    @endswitch
                                ">
                                    {{ $aktaInfo->first()->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-end mb-2">
                        <a href="{{ route('akta-parties.createData', ['akta_transaction_id' => $aktaInfo->first()->id]) }}"
                            class="btn btn-primary btn-sm mb-2">
                            + Tambah Pihak Akta
                        </a>
                    </div>

                    <table class="table align-items-center mb-0">
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
                            <tr class="text-sm text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $party->name }}</td>
                                <td><span class="badge bg-info">{{ $party->role }}</span></td>
                                <td>{{ $party->address ?? '-' }}</td>
                                <td>{{ $party->id_number ?? '-' }}</td>
                                <td>{{ $party->id_type ?? '-' }}</td>
                                <td>{{ $party->note ?? '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('akta-parties.edit', $party->id) }}"
                                        class="btn btn-warning btn-sm">
                                        Edit
                                    </a>
                                    <form action="{{ route('akta-parties.destroy', $party->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus pihak ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada pihak terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                @else
                <p class="text-center text-muted text-sm">Silakan cari kode registrasi atau nomor akta untuk menampilkan
                    pihak-pihak.</p>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection