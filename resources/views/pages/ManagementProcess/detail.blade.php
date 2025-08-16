@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Detail Notary Client Product'])

<div class="container mt-4">
    <div class="card mb-4">
        <div class="card-header">
            <h5>Detail Produk</h5>
        </div>
        <div class="card-body">
            <table class="table table-borderless mb-0">
                <tbody>
                    <tr>
                        <th>Registration Code</th>
                        <td>{{ $product->registration_code }}</td>
                    </tr>
                    <tr>
                        <th>Client Name</th>
                        <td>{{ $product->client->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Product Name</th>
                        <td>{{ $product->product->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge bg-{{ $product->status == 'done' ? 'success' : 'warning' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Last Progress</th>
                        <td>
                            @if($product->last_progress)
                            {{ $product->last_progress->progress }}
                            @else
                            Awal Permohonan
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Last Progress Date</th>
                        <td>
                            @if($product->last_progress)
                            {{ \Carbon\Carbon::parse($product->last_progress->progress_date)->format('d M Y') }}
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Histori Progress --}}
    <div class="card">
        <div class="card-header">
            <h5>Histori Progress</h5>
        </div>
        <div class="card-body">
            @if($progresses->isEmpty())
            <p class="text-muted">Belum ada progress.</p>
            @else
            <ul class="list-group">
                @foreach($progresses as $progress)
                <li class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $progress->progress }}</strong><br>
                            <small class="text-muted">{{ $progress->note }}</small>
                        </div>
                        <div>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($progress->progress_date)->format('d M
                                Y') }}</small>
                        </div>
                    </div>
                    @if($progress->status)
                    <span class="badge bg-info mt-2">{{ ucfirst($progress->status) }}</span>
                    @endif
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>

    {{-- Tombol Kembali --}}
    <div class="mt-4">
        <a href="{{ route('management-process.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>
</div>
@endsection