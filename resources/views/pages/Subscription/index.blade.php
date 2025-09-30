@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Subscription'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                <h5>Subscription</h5>
                <form action="{{ route('subscriptions') }}" method="GET" class="d-flex" class="no-spinner">
                    <input type="text" name="search" class="form-control form-control-sm me-2"
                        placeholder="Cari subscription..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-primary mb-0">Cari</button>
                </form>
            </div>
            <div class="card-body px-0  pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="th-title">
                                    #
                                </th>
                                <th class="th-title">
                                    Nama
                                </th>
                                <th class="th-title">
                                    Harga
                                </th>
                                <th class="th-title">
                                    Tanggal Aktif
                                </th>
                                <th class="th-title">
                                    Tanggal Kadaluarsa
                                </th>
                                <th class="th-title">
                                    Tanggal Bayar
                                </th>

                                <th class="th-title">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subscriptions as $subscription)
                            <tr class="text-center">
                                <td>
                                    <p class="text-sm mb-0 ">{{ $loop->iteration }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  "> {{
                                        $subscription->plan->name
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0">
                                        Rp. {{ number_format($subscription->plan->price, 0, ',', '.') }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  ">{{
                                        \Carbon\Carbon::parse($subscription->start_date)->format('d-m-Y') }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  ">{{
                                        \Carbon\Carbon::parse($subscription->end_date)->format('d-m-Y')
                                        }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  ">{{
                                        \Carbon\Carbon::parse($subscription->payment_date)->format('d-m-Y') }}</p>
                                </td>

                                <td>
                                    <span
                                        class="badge  bg-{{ $subscription->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ $subscription->status == 'active' ? 'Aktif' : 'Non Aktif' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data subscription.</td>
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