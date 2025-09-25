@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Konsultasi'])
<div class="row mt-4 mx-4">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4 px-3 flex-wrap">
                <h6>Konsultasi</h6>
                <a href="{{ route('consultation.create') }}" class="btn btn-primary btn-sm mb-0">
                    + Tambah Konsultasi
                </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="th-title">
                                    #
                                </th>
                                {{-- <th class="th-title">
                                    Notaris
                                </th> --}}
                                <th class="th-title">
                                    Klien
                                </th>
                                <th class="th-title">
                                    Kode Registrasi
                                </th>
                                <th class="th-title">
                                    Subjek
                                </th>
                                <th class="th-title">
                                    Deskripsi
                                </th>
                                <th class="th-title">
                                    Status
                                </th>
                                <th class="th-title">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($notaryConsultations as $notaryconsultation)
                            <tr>
                                <td>
                                    <p class="text-sm mb-0 text-center">{{ $loop->iteration }}</p>
                                </td>
                                {{-- <td>
                                    <p class="text-sm mb-0  text-center"> {{
                                        $notaryconsultation->notaris->display_name
                                        }}
                                    </p>
                                </td> --}}
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        $notaryconsultation->client->fullname
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        $notaryconsultation->registration_code }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        $notaryconsultation->subject }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        $notaryconsultation->description ?? '-' }}
                                    </p>
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge px-2  py-2 text-center d-inline-block
                                        bg-{{ $notaryconsultation->status == 'done' ? 'success' : ($notaryconsultation->status == 'progress' ? 'warning' : 'secondary') }}">
                                        @if ($notaryconsultation->status == 'done')
                                        Selesai
                                        @elseif ($notaryconsultation->status == 'progress')
                                        Sedang Diproses
                                        @else
                                        {{ ucfirst($notaryconsultation->status) }}
                                        @endif
                                    </span>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('consultation.edit', $notaryconsultation->id) }}"
                                        class="btn btn-info btn-xs mb-0">
                                        <i class="fa-solid fa-pencil" style="font-size: 14px">
                                        </i>
                                    </a>
                                    {{-- get product by consultation --}}
                                    {{-- <a href="{{ route('consultation.detail', $notaryconsultation->id) }}"
                                        class="btn btn-warning btn-xs mb-0">
                                        <i class="fa-solid fa-list" style="font-size: 14px">
                                        </i>
                                    </a> --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted w-100 text-sm">Belum ada data Konsultasi.
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