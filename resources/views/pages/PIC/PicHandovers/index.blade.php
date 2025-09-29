@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Serah Terima Dokumen'])

<div class="row mt-4 mx-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header pb-0">
                <h5>Serah Terima Dokumen</h5>
            </div>
            <div class="card-body pb-0">
                <form method="GET" action="{{ route('pic_handovers.index') }}"
                    class="d-flex justify-content-between gap-2 mb-2">
                    <div class="input-group input-group-sm" style="max-width: 400px;" class="no-spinner">
                        <input type="text" name="search" class="form-control"
                            placeholder="Cari berdasarkan kode dokumen" value="{{ request('search') }}">
                        <button class="btn btn-primary mb-0" type="submit">Cari</button>
                    </div>
                    <div>
                        <a href="{{ route('pic_handovers.create') }}" class="btn btn-primary btn-sm mb-0">
                            + Tambah Serah Terima
                        </a>
                    </div>
                </form>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Dokumen</th>
                            <th>Tanggal</th>
                            <th>Penerima</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($handovers as $handover)
                        <tr class="text-center text-sm">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $handover->picDocument->pic_document_code }}</td>
                            <td>{{ $handover->handover_date }}</td>
                            <td>{{ $handover->recipient_name }}</td>
                            <td>{{ $handover->note }}</td>
                            <td>
                                {{-- Tombol PDF --}}
                                <a href="{{ route('pic_handovers.print', $handover->id) }}"
                                    class="btn btn-sm  btn btn-dark mb-0" target="_blank" title="Cetak PDF">
                                    <i class="fas fa-file-pdf" style="font-size: 15px;"></i>
                                </a>

                                {{-- Tombol Hapus (buka modal) --}}
                                <button type="button" class="btn btn-sm btn-danger mb-0" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $handover->id }}" title="Hapus">
                                    {{-- <i class="fas fa-trash-alt"></i> --}}
                                    Hapus
                                </button>

                                {{-- Modal Konfirmasi Hapus --}}
                                <div class="modal fade" id="deleteModal{{ $handover->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel{{ $handover->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $handover->id }}">
                                                    Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus data serah terima ini? <br>
                                                <strong>Kode Dokumen: {{ $handover->picDocument->pic_document_code
                                                    }}</strong>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('pic_handovers.destroy', $handover->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-sm">Tidak ada data serah terima.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection