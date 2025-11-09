<div class="modal fade" id="deleteModal{{ $client->id }}" tabindex="-1"
    aria-labelledby="deleteModalLabel{{ $client->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $client->id }}">
                     Data Klien</h5>
                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-xmark text-dark fs-4"></i>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data klien <strong>{{ $client->name }}</strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mb-0 btn-sm" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger mb-0 btn-sm">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
