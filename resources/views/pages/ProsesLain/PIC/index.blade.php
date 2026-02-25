@extends('layouts.app')

@section('title', 'PIC')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Pic'])
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-header pb-0 mb-0 ">
                    <div class=" d-flex justify-content-between align-items">
                        <h5 class="mb-0">Pic</h5>
                        @if (auth()->user()->access_code !== 'staff')
                            <a href="{{ route('proses-lain-pic.create') }}" class="btn btn-primary btn-sm mb-0">
                                + Tambah PIC
                            </a>
                        @else
                            <form method="GET" action="{{ route('proses-lain-pic.index') }}"
                                class="d-flex gap-2 ms-auto mt-0" style="width:550px;">

                                <input type="text" name="search" placeholder="Cari nama pic..."
                                    value="{{ request('search') }}" class="form-control">
                                <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                            </form>
                        @endif
                    </div>
                    @if (auth()->user()->access_code !== 'staff')
                        <form method="GET" action="{{ route('proses-lain-pic.index') }}" class="d-flex gap-2 ms-auto mt-3"
                            style="max-width:550px;">

                            <input type="text" name="search" placeholder="Cari nama pic..."
                                value="{{ request('search') }}" class="form-control">
                            <button type="submit" class="btn btn-primary btn-sm mb-0">Cari</button>
                        </form>
                    @endif
                </div>
                <hr>
                <div class="card-body px-0 pt-0 pb-0">
                    <div class="table-responsive p-0">

                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="th-title">
                                        #
                                    </th>
                                    <th class="th-title">
                                        Notaris
                                    </th>
                                    <th class="th-title">
                                        Klien
                                    </th>
                                    <th class="th-title">
                                        Nama Transaksi
                                    </th>
                                    <th>
                                        Pic
                                    </th>
                                    {{-- <th class="th-title">
                                        Aksi
                                    </th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($prosesLain as $document)
                                    <tr class="text-center text-sm">
                                        <td>
                                            <p class="text-sm mb-0 text-center">
                                                {{ $prosesLain->firstItem() + $loop->index }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0  text-center"> {{ $document->notaris->display_name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0  text-center"> {{ $document->client->fullname }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0  text-center">{{ $document->name }}
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-sm mb-0  text-center">
                                                {{ $document->picDocument->pic->full_name ?? '-' }}
                                            </p>
                                        </td>


                                        {{-- <td class="text-center align-middle">
                                            <a href="{{ route('proses-lain-pic.edit', $document->id) }}"
                                                class="btn btn-info btn-sm mb-0">
                                                Edit
                                            </a>

                                            <form action="{{ route('proses-lain-pic.destroy', $document->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm mb-0">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted text-sm">Belum ada data pic.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end mt-3">
                            {{ $prosesLain->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
