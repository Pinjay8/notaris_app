@extends('layouts.app')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Subscription'])
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <h6>Subscription</h6>
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
                                    Nama Paket
                                </th>
                                <th class="th-title">
                                    Harga
                                </th>
                                <th class="th-title">
                                    Tanggal Aktif
                                </th>
                                <th class="th-title">
                                    Tanggal Bayar
                                </th>
                                <th class="th-title">
                                    Tanggal Kadaluarsa
                                </th>
                                <th class="th-title">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subscriptions as $subscription)
                            <tr>
                                <td>
                                    <p class="text-sm mb-0 text-center">{{ $loop->iteration }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center"> {{
                                        $subscription->plan->name
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">Rp. {{
                                        $subscription->plan->price
                                        }}
                                    </p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        \Carbon\Carbon::parse($subscription->start_date)->format('d-m-Y H:i') }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        \Carbon\Carbon::parse($subscription->payment_date)->format('d-m-Y H:i') }}</p>
                                </td>
                                <td>
                                    <p class="text-sm mb-0  text-center">{{
                                        \Carbon\Carbon::parse($subscription->end_date)->format('d-m-Y H:i')
                                        }}</p>
                                </td>
                                <td>
                                    <span
                                        class="badge text-center d-block mx-auto bg-{{ $subscription->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ $subscription->status == 'active' ? 'Aktif' : 'Non Aktif' }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada data langganan.</td>
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