@if($notaryPayment->isNotEmpty())
<div class="table-responsive">
    <table class="table table-striped table-bordered align-middle">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Kode Pajak</th>
                <th>Tanggal Bayar</th>
                <th>Jumlah</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notaryPayment as $payment)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $payment->tax_code ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($payment->created_at)->format('d-m-Y') }}</td>
                <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                <td>
                    @if($payment->is_valid)
                    <span class="badge bg-success">Lunas</span>
                    @else
                    <span class="badge bg-warning">Menunggu Validasi</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
<div class="d-flex flex-column justify-content-center align-items-center text-center py-5" style="min-height:200px;">
    <img src="{{ asset('img/bg-nodata.svg') }}" alt="No Data" style="width:150px; max-width:100%">
    <p class="mt-3 fw-bold text-muted fs-7">Belum ada data pembayaran</p>
</div>
@endif