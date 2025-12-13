<?php

namespace App\Repositories;

use App\Models\NotaryWaarmerking;
use App\Repositories\Interfaces\WaarmerkingRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class WaarmerkingRepository implements WaarmerkingRepositoryInterface
{
    public function getAll(array $filters, int $perPage): LengthAwarePaginator
    {
        $query = NotaryWaarmerking::query()->where('notaris_id', auth()->user()->notaris_id);

        if (!empty($filters['waarmerking_number'])) {
            $query->where('waarmerking_number', 'like', '%' . $filters['waarmerking_number'] . '%');
        }

        if (!empty($filters['sort']) && in_array($filters['sort'], ['asc', 'desc'])) {
            $query->orderBy('release_date', $filters['sort']);
        } else {
            $query->orderBy('release_date', 'desc');
        }

        return $query->paginate($perPage);
    }


    public function findById(int $id)
    {
        return NotaryWaarmerking::findOrFail($id);
    }

    public function create(array $data)
    {
        return NotaryWaarmerking::create($data);
    }

    public function update(int $id, array $data)
    {
        $waarmerking = $this->findById($id);
        $waarmerking->update($data);
        return $waarmerking;
    }

    public function delete(int $id)
    {
        $waarmerking = $this->findById($id);
        return $waarmerking->delete();
    }
}
