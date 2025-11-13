{{-- Modal Upload --}}
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Tambah Dokumen Klien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <form method="POST" action="{{ route('management-document.addDocument') }}" enctype="multipart/form-data">
                @csrf
                {{-- Hidden input wajib --}}
                {{-- <input type="hidden" name="client_code" value="{{ $product->client_code }}">
                <input type="hidden" name="notaris_id" value="{{ $product->notaris_id }}">
                <input type="hidden" name="client_id" value="{{ $product->client_id }}"> --}}

                <div class="modal-body">

                    {{-- client_id --}}
                    <div class="mb-3">
                        <label class="form-label">Client</label>
                        @php
                            $clients = $clients ?? collect();
                        @endphp
                        <select name="client_id" class="form-select" required>
                            <option value="" hidden>Pilih Klien</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->fullname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kode Dokumen</label>
                        <input type="text" name="document_code" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Dokumen</label>
                        <input type="text" name="document_name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File Dokumen</label>
                        <input type="file" name="document_link" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="note" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Upload</label>
                        <input type="date" name="uploaded_at" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
