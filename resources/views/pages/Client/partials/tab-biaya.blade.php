@if($notaryCost->isNotEmpty())
<div class="table-responsive">
    <table class="table table-striped table-bordered align-middle">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Kode Pembayaran</th>
                <th>Tanggal Bayar</th>
                <th>Jumlah Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notaryCost as $cost)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $cost->payment_code ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($cost->created_at)->format('d-m-Y') }}</td>
                <td>Rp {{ number_format($cost->amount_paid, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end fw-bold">Sisa Pembayaran</td>
                <td class="text-center fw-bold">
                    Rp {{ number_format($notaryCost->sum('total_cost') - $notaryCost->sum('amount_paid'),0,',','.') }}
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-end fw-bold">Total Tagihan</td>
                <td class="text-center fw-bold">
                    Rp {{ number_format($notaryCost->sum('total_cost'),0,',','.') }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>
@else
<div class="d-flex flex-column justify-content-center align-items-center text-center py-5" style="min-height:200px;">
    <img src="{{ asset('img/bg-nodata.svg') }}" alt="No Data" style="width:150px; max-width:100%;">
    <p class="mt-3 fw-bold text-muted fs-7">Belum ada data biaya</p>
</div>

@endif