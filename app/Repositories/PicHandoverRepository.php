<?php

namespace App\Repositories;

use App\Models\PicHandOver;
use App\Repositories\Interfaces\PicHandoverRepositoryInterface;

class PicHandoverRepository implements PicHandoverRepositoryInterface
{
    public function all(array $filters = [])
    {
        $query = PicHandover::with(['picDocument']);

        // Ambil search dengan aman (tidak error meskipun tidak dikirim dari request)
        $search = $filters['search'] ?? null;

        if (!empty($search)) {
            $query->whereHas('picDocument', function ($q) use ($search) {
                $q->where('pic_document_code', 'like', '%' . $search . '%');
            });
        }

        return $query->latest()->paginate(10);
    }

    public function find($id)
    {
        return PicHandover::with(['picDocument'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return PicHandover::create($data);
    }

    public function delete($id)
    {
        return PicHandover::destroy($id);
    }
}
