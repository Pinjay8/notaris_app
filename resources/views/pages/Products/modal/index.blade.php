<div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1"
    aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">
                    Konfirmasi Hapus</h5>
                <button type="button" class="btn border-0 bg-transparent" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-xmark text-dark fs-4"></i>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus produk <strong>{{ $product->name
                    }}</strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>