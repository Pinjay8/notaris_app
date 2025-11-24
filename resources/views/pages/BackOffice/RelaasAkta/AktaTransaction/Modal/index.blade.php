<!-- Modal Delete per item -->
<div class="modal fade" id="deleteModal{{ $akta->id }}" tabindex="-1"
    aria-labelledby="deleteModalLabel{{ $akta->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $akta->id }}">
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah kamu yakin ingin menghapus transaksi akta ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('relaas-aktas.destroy', $akta->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="client_code" value="{{ request('client_code') }}">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
