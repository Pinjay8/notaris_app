<?php

namespace App\Repositories;

use App\Repositories\Interfaces\NotaryLegalisasiRepositoryInterface;
use App\Models\NotaryLegalisasi;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class NotaryLegalisasiRepository implements NotaryLegalisasiRepositoryInterface
{
    public function getAll(array $filters, int $perPage): LengthAwarePaginator
    {
        $query = NotaryLegalisasi::query();

        if (!empty($filters['legalisasi_number'])) {
            $query->where('legalisasi_number', 'like', '%' . $filters['legalisasi_number'] . '%');
        }

        if (!empty($filters['sort']) && in_array($filters['sort'], ['asc', 'desc'])) {
            $query->orderBy('release_date', $filters['sort']);
        } else {
            $query->orderBy('release_date', 'desc');
        }

        return $query->paginate($perPage);
    }

    public function findById(int $id): ?NotaryLegalisasi
    {
        return NotaryLegalisasi::find($id);
    }

    public function create(array $data): NotaryLegalisasi
    {
        return NotaryLegalisasi::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $legalisasi = $this->findById($id);
        if (!$legalisasi) {
            return false;
        }
        return $legalisasi->update($data);
    }

    public function delete(int $id): bool
    {
        $legalisasi = $this->findById($id);
        if (!$legalisasi) {
            return false;
        }
        return (bool) $legalisasi->delete();
    }
}
