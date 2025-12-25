<?php

namespace App\Services;

use App\Models\NotaryRelaasAkta;
use App\Models\NotaryRelaasDocument;
use Illuminate\Support\Facades\Storage;

class NotaryRelaasDocumentService
{
    /**
     * Cari relaas berdasarkan registration_code atau relaas_number
     */
    public function searchRelaas(string $search)
    {
        return NotaryRelaasAkta::where('transaction_code', $search)
            ->where('notaris_id', auth()->user()->notaris_id)
            ->orWhere('relaas_number', $search)
            ->first();
    }

    /**
     * Ambil semua dokumen dari relaas tertentu
     */
    public function getDocuments(int $relaasId)
    {
        return NotaryRelaasDocument::where('relaas_id', $relaasId)
            ->where('notaris_id', auth()->user()->notaris_id)
            ->orderBy('uploaded_at', 'desc')
            ->paginate(10);
    }

    /**
     * Cari dokumen berdasarkan ID
     */
    public function findById(int $id)
    {
        return NotaryRelaasDocument::findOrFail($id);
    }

    /**
     * Simpan dokumen baru
     */
    public function store(array $data)
    {
        return NotaryRelaasDocument::create($data);
    }

    /**
     * Update dokumen
     */
    public function update(int $id, array $data)
    {
        $document = $this->findById($id);
        $document->update($data);

        return $document;
    }

    /**
     * Hapus dokumen
     */
    public function destroy(int $id)
    {
        $document = $this->findById($id);

        return $document->delete();
    }

    /**
     * Toggle status dokumen (misal: active / inactive)
     */
    public function toggleStatus(int $id)
    {
        $document = $this->findById($id);
        $document->status = !$document->status;
        $document->save();

        return $document;
    }
}
