<form action="{{ route('notary_payments.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="payment_code" value="{{ $cost->payment_code }}">
    <input type="hidden" name="payment_type" value="{{ $type }}">

    <div class="mb-2">
        <label for="amount-{{ $type }}">Jumlah Bayar</label>
        <input type="text" name="amount" id="amount-{{ $type }}"
            class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}">
        @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-2">
        <label for="payment_date-{{ $type }}">Tanggal Bayar</label>
        <input type="date" name="payment_date" id="payment_date-{{ $type }}"
            class="form-control @error('payment_date') is-invalid @enderror" value="{{ old('payment_date') }}">
        @error('payment_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-2">
        <label for="payment_method-{{ $type }}">Metode Bayar</label>
        <select name="payment_method" id="payment_method-{{ $type }}"
            class="form-control @error('payment_method') is-invalid @enderror">
            <option value="" hidden>Pilih Metode</option>
            <option value="cash" {{ old('payment_method')=='cash' ? 'selected' : '' }}>Cash</option>
            <option value="transfer" {{ old('payment_method')=='transfer' ? 'selected' : '' }}>Transfer</option>
        </select>
        @error('payment_method') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-2">
        <label for="payment_file-{{ $type }}">Bukti Pembayaran</label>
        <input type="file" name="payment_file" id="payment_file-{{ $type }}"
            class="form-control @error('payment_file') is-invalid @enderror">
        @error('payment_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mb-2">
        <label for="note-{{ $type }}">Catatan</label>
        <textarea name="note" id="note-{{ $type }}"
            class="form-control @error('note') is-invalid @enderror">{{ old('note') }}</textarea>
        @error('note') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-success">Simpan</button>
</form>

@push('js')
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('#pills-{{ $type }} form'); // form di tab ini aja
    const amountInput = form.querySelector('[name="amount"]');

    // format input
    amountInput.addEventListener('input', function () {
        let value = this.value.replace(/\D/g, '');
        this.value = value ? new Intl.NumberFormat('id-ID').format(value) : '';
    });

    // sebelum submit → hapus titik
    form.addEventListener('submit', function () {
        amountInput.value = amountInput.value.replace(/\./g, '');
    });
});
</script>
@endpush