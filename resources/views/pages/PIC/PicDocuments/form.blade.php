@extends('layouts.app')

@section('title', 'Pic Dokumen')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'PIC Dokumen'])

    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>{{ isset($picDocument) ? 'Edit' : 'Tambah' }} PIC Dokumen</h6>
                </div>
                <hr>
                <div class="card-body px-4 pt-0 pb-2">
                    <form
                        action="{{ isset($picDocument) ? route('pic_documents.update', $picDocument) : route('pic_documents.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($picDocument))
                            @method('PUT')
                        @endif

                        {{-- PIC Staff --}}
                        <div class="mb-3">
                            <label for="pic_id" class="form-label text-sm">PIC Staff</label>
                            <select name="pic_id" id="pic_id" class="form-select">
                                <option value="" hidden>Pilih PIC Staff</option>
                                @foreach ($picStaffList as $pic)
                                    <option value="{{ $pic->id }}"
                                        {{ old('pic_id', $picDocument->pic_id ?? '') == $pic->id ? 'selected' : '' }}>
                                        {{ $pic->full_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Klien --}}
                        <div class="mb-3">
                            <label for="client_code" class="form-label text-sm">Klien</label>
                            <select name="client_code" id="client_code" class="form-select select2">
                                <option value="" hidden>Pilih Klien</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->client_code }}"
                                        {{ old('client_code', $picDocument->client_code ?? '') == $client->client_code ? 'selected' : '' }}>
                                        {{ $client->fullname }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tipe Transaksi --}}
                        <div class="mb-3">
                            <label for="transaction_type" class="form-label text-sm">Tipe Transaksi</label>
                            <select name="transaction_type" id="transaction_type" class="form-select">
                                <option value="" hidden>Pilih Tipe Transaksi</option>
                                <option value="akta"
                                    {{ old('transaction_type', $picDocument->transaction_type ?? '') == 'akta' ? 'selected' : '' }}>
                                    Akta
                                </option>
                                <option value="ppat"
                                    {{ old('transaction_type', $picDocument->transaction_type ?? '') == 'ppat' ? 'selected' : '' }}>
                                    PPAT
                                </option>
                            </select>
                        </div>

                        {{-- Akta Transaction --}}
                        <div class="mb-3" id="akta_section" style="display: none;">
                            <label for="transaction_id" class="form-label text-sm">Transaksi Akta</label>
                            <select name="transaction_id" id="transaction_id" class="form-select">
                                <option value="" hidden>Pilih Transaksi</option>
                                @foreach ($aktaTransaction as $akta)
                                    <option value="{{ $akta->id }}"
                                        {{ old('transaction_id', $picDocument->transaction_id ?? '') == $akta->id ? 'selected' : '' }}>
                                        {{ $akta->akta_type->type ?? '-' }} - {{ $akta->akta_number ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Relaas Transaction --}}
                        <div class="mb-3" id="relaas_section" style="display: none;">
                            <label for="transaction_id" class="form-label text-sm">Transaksi PPAT</label>
                            <select name="transaction_id" id="transaction_id" class="form-select">
                                <option value="" hidden>Pilih Transaksi PPAT</option>
                                @foreach ($relaasTransaction as $relaas)
                                    <option value="{{ $relaas->id }}"
                                        {{ old('transaction_id', $picDocument->transaction_id ?? '') == $relaas->id ? 'selected' : '' }}>
                                        {{ $relaas->akta_type->type ?? '-' }} - {{ $relaas->relaas_number ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tanggal Terima --}}
                        <div class="mb-3">
                            <label for="received_date" class="form-label text-sm">Tanggal Terima</label>
                            <input type="datetime-local" name="received_date" id="received_date" class="form-control"
                                value="{{ old('received_date', isset($picDocument->received_date) ? \Carbon\Carbon::parse($picDocument->received_date)->format('Y-m-d\TH:i') : '') }}">
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label for="status" class="form-label text-sm">Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="">Pilih Status</option>
                                <option value="delivered"
                                    {{ old('status', $picDocument->status ?? '') == 'delivered' ? 'selected' : '' }}>
                                    Dikirim</option>
                                <option value="process"
                                    {{ old('status', $picDocument->status ?? '') == 'process' ? 'selected' : '' }}>Proses
                                </option>
                                <option value="received"
                                    {{ old('status', $picDocument->status ?? '') == 'received' ? 'selected' : '' }}>
                                    Diterima</option>
                                <option value="completed"
                                    {{ old('status', $picDocument->status ?? '') == 'completed' ? 'selected' : '' }}>
                                    Selesai</option>
                            </select>
                        </div>

                        {{-- Catatan --}}
                        <div class="mb-3">
                            <label for="note" class="form-label text-sm">Catatan</label>
                            <textarea name="note" id="note" class="form-control" rows="3">{{ old('note', $picDocument->note ?? '') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('pic_documents.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">
                                {{ isset($picDocument) ? 'Update' : 'Simpan' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- JS untuk toggle --}}
    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const typeSelect = document.getElementById('transaction_type');
                const aktaSection = document.getElementById('akta_section');
                const relaasSection = document.getElementById('relaas_section');

                function toggleSections() {
                    const value = typeSelect.value;
                    aktaSection.style.display = value === 'akta' ? 'block' : 'none';
                    relaasSection.style.display = value === 'ppat' ? 'block' : 'none';
                }

                // Trigger pertama kali saat load (biar sesuai value old())
                toggleSections();

                // Ubah tampilan ketika select berubah
                typeSelect.addEventListener('change', toggleSections);
            });
        </script>
    @endpush
@endsection
