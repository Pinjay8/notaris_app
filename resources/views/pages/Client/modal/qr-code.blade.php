<!-- Modal -->
<div class="modal fade" id="qrModal{{ $client->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3 text-center">
            <h5 class="mb-3">QR Code Klien</h5>
            @php
            $link = url("/clients/{$client->uuid}");
            $dns2d = new \Milon\Barcode\DNS2D();
            $pngData = $dns2d->getBarcodePNG($link, 'QRCODE', 10, 10);
            $qrCodePng = base64_encode($pngData);
            @endphp
            @php
            file_put_contents(storage_path('app/public/test.png'), base64_decode($qrCodePng));
            @endphp

            <img src="data:image/png;base64,{{ $qrCodePng }}" alt="QR Code" />
            {{-- <p class="small mb-3">{{ $link }}</p>
            <pre></pre> --}}

            <div class="d-flex justify-content-center gap-2">
                <a href="data:image/png;base64,{{ $qrCodePng }}" download="qrcode-{{ $client->uuid }}.png"
                    class="btn btn-primary btn-sm">Download</a>
                <a href="https://wa.me/?text={{ urlencode('Silakan akses: ' . $link) }}" target="_blank"
                    class="btn btn-success btn-sm">Share
                    WhatsApp</a>
            </div>
        </div>
    </div>
</div>