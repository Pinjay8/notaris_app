<?php

namespace App\Repositories;

use App\Models\PicDocuments;
use App\Repositories\Interfaces\PicDocumentsRepositoryInterface;

class PicDocumentsRepository implements PicDocumentsRepositoryInterface
{
    public function getAll($filters = [])
    {
        $query = PicDocuments::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('registration_code', 'like', "%$search%")
                ->orWhereHas('pic', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->latest()->paginate(10);
    }

    public function findById($id)
    {
        return PicDocuments::findOrFail($id);
    }

    public function create(array $data)
    {
        return PicDocuments::create($data);
    }

    public function update($id, array $data)
    {
        $picDocument = $this->findById($id);
        $picDocument->update($data);
        return $picDocument;
    }

    public function delete($id)
    {
        $picDocument = $this->findById($id);
        return $picDocument->delete();
    }
}
