<?php

namespace App\Repositories;

use App\Models\NotaryRelaasDocument;

class NotaryRelaasDocumentRepository
{
    public function search($keyword)
    {
        return NotaryRelaasDocument::query()
            ->where('registration_code', 'like', "%{$keyword}%")
            ->orWhere('name', 'like', "%{$keyword}%")
            ->get();
    }

    public function getById($id)
    {
        return NotaryRelaasDocument::findOrFail($id);
    }

    public function create(array $data)
    {
        return NotaryRelaasDocument::create($data);
    }

    public function updateStatus($id, $status)
    {
        $doc = NotaryRelaasDocument::findOrFail($id);
        $doc->status = $status;
        $doc->save();
        return $doc;
    }

    public function delete($id)
    {
        $doc = NotaryRelaasDocument::findOrFail($id);
        if ($doc->file_url && file_exists(public_path($doc->file_url))) {
            unlink(public_path($doc->file_url));
        }
        return $doc->delete();
    }
}
