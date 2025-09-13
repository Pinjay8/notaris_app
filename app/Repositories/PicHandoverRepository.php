<?php

namespace App\Repositories;

use App\Models\PicHandover;
use App\Repositories\Interfaces\PicHandoverRepositoryInterface;

class PicHandoverRepository implements PicHandoverRepositoryInterface
{
    public function all(array $filters = [])
    {
        $query = PicHandover::with(['picDocument']);

        if (!empty($filters['search'])) {
            $query->whereHas('picDocument', function ($q) use ($filters) {
                $q->where('pic_document_code', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->latest()->get();
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
