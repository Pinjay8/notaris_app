<?php

namespace App\Repositories;

use App\Models\NotaryAktaTypes;
use App\Repositories\Interfaces\NotaryAktaTypeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class NotaryAktaTypeRepository implements NotaryAktaTypeRepositoryInterface
{
    public function all(array $filters = []): Collection
    {
        $query = NotaryAktaTypes::query();

        if (!empty($filters['search'])) {
            $query->where('type', 'like', '%' . $filters['search'] . '%')
                ->orWhere('description', 'like', '%' . $filters['search'] . '%');
        }

        // if (isset($filters['status'])) {
        //     $query->where('status', $filters['status']);
        // }

        return $query->latest()->get();
    }

    public function find(int $id): ?NotaryAktaTypes
    {
        return NotaryAktaTypes::find($id);
    }

    public function create(array $data): NotaryAktaTypes
    {
        return NotaryAktaTypes::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $aktaType = $this->find($id);
        if (!$aktaType) return false;
        return $aktaType->update($data);
    }

    public function delete(int $id): bool
    {
        $aktaType = $this->find($id);
        if (!$aktaType) return false;
        return $aktaType->delete();
    }
}
