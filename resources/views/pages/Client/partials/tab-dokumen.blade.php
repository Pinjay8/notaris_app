{{-- Tab Dokumen --}}
<div class="card mb-4">
    <div class="card-header pb-0">
        <div class="mb-1">
            <h6 class="fw-bold">Dokumen yang harus dikirim</h6>
            @if($documents->isEmpty())
            <p class="text-muted">Belum ada dokumen yang harus dikirim.</p>
            @else
            <ul class="list-group">
                @foreach($documents as $doc)
                <li class="list-group-item list-group-item-secondary">
                    {{ $doc->name }}
                </li>
                @endforeach
            </ul>
            @endif
        </div>
        <hr>
        <h6>Upload Dokumen</h6>
    </div>
    <div class="card-body pt-1">
        <form action="{{ route('client.uploadDocument', $client->uuid) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label text-sm">Jenis Dokumen</label>
                <select name="document_code" class="form-select" required>
                    <option value="" hidden>Pilih Dokumen</option>
                    @foreach($documents as $doc)
                    <option value="{{ $doc->code }}">{{ $doc->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label text-sm">File Dokumen</label>
                <input type="file" name="document_link" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label text-sm">Catatan</label>
                <textarea name="note" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

    <div class="card-footer pt-0">
        <hr class="mt-0">
        @if($clientDocuments->isEmpty())
        <div class="text-center text-muted py-5">
            <i class="fas fa-file-alt fa-2x mb-2"></i>
            <p>Belum ada dokumen yang diunggah</p>
        </div>
        @else
        <div class="mb-2 fw-bold text-black ">Dokumen yang sudah diunggah</div>
        <p style="font-size: 14px">Klik pada judul untuk membuka detail dokumen</p>
        <div class="accordion" id="uploadedDocsAccordion">
            @foreach($clientDocuments as $index => $doc)
            <div class="accordion-item  rounded-4 border-2">
                <h2 class="accordion-header" id="heading-{{ $index }}">
                    <button class="accordion-button collapsed d-flex justify-content-between bg-light" type="button"
                        data-bs-toggle="collapse" data-bs-target="#collapse-{{ $index }}" aria-expanded="false"
                        aria-controls="collapse-{{ $index }}">
                        <div class="d-flex align-items-center w-100">
                            <span class="me-2 fw-bold">{{ $index + 1 }}.</span>
                            <span>{{ $doc->document_name }}</span>
                        </div>
                        <div class="ms-auto">
                            @if($doc->status == 'new')
                            <span class="badge bg-warning">Menunggu Validasi</span>
                            @elseif($doc->status == 'valid')
                            <span class="badge bg-success">Valid</span>
                            @elseif($doc->status == 'invalid')
                            <span class="badge bg-danger fs-7">Invalid - Upload Ulang</span>
                            @endif
                        </div>
                    </button>
                </h2>
                <div id="collapse-{{ $index }}" class="accordion-collapse collapse"
                    aria-labelledby="heading-{{ $index }}" data-bs-parent="#uploadedDocsAccordion">
                    <div class="accordion-body">
                        <p><strong>Kode Dokumen:</strong> {{ $doc->document_code }}</p>
                        <p><strong>Catatan:</strong> {{ $doc->note ?? '-' }}</p>
                        <p><strong>Tanggal Upload:</strong> {{ $doc->uploaded_at ? $doc->uploaded_at->format('d-m-Y
                            H:i') : '-' }}</p>
                        <p>
                            <a href="{{ asset('storage/' . $doc->document_link) }}" target="_blank"
                                class="btn btn-sm btn-primary">
                                <i class="fa fa-file"></i> Lihat File
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>