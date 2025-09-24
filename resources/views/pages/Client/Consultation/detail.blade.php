@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Detail Konsultasi'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center mb-4 px-3 flex-wrap">
                <h6>List Produk Konsultasi</h6>
                <a href="{{ route('consultation.creates', ['consultationId' => $consultationId]) }}"
                    class="btn btn-primary btn-sm mb-0">
                    + Tambah Produk
                </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="th-title">
                                    Id
                                </th>
                                <th class="th-title">
                                    Notaris
                                </th>
                                <th class="th-title">
                                    Klien
                                </th>
                                <th class="th-title">
                                    Kode Registrasi
                                </th>
                                <th class="th-title">
                                    Produk
                                </th>
                                <th class="th-title">
                                    Note
                                </th>
                                <th class="th-title">
                                    Status
                                </th>
                                <th class="th-title">
                                    Completed At
                                </th>
                                <th class="th-title">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($notaryClientProduct as $product)
                            <tr class="text-center text-sm">
                                <td>
                                    {{ $product->id }}
                                </td>
                                <td>
                                    {{ $product->notaris->display_name }}
                                </td>
                                <td>
                                    {{ $product->client->fullname }}
                                </td>
                                <td>
                                    {{ $product->registration_code }}
                                </td>
                                <td>
                                    {{ $product->product->name }}
                                </td>
                                <td>
                                    {{ $product->note }}
                                </td>
                                <td>
                                    {{ $product->status }}
                                </td>
                                <td>
                                    {{ $product->completed_at }}
                                </td>
                                <td>
                                    <form
                                        action="{{ route('consultation.deleteProduct', ['consultationId' => $consultation->id, 'productId' => $product->product_id]) }}"
                                        method="POST"
                                        style="display: flex; justify-content: center; align-items: center;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs text-center mb-0">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted text-sm">Belum ada data list produk
                                    konsultasi.</td>
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