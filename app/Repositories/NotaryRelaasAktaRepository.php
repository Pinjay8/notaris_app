<?php

namespace App\Repositories;

use App\Models\NotaryRelaasAkta;
use App\Repositories\Interfaces\NotaryRelaasAktaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class NotaryRelaasAktaRepository implements NotaryRelaasAktaRepositoryInterface
{
    public function all(): Collection
    {
        return NotaryRelaasAkta::all();
    }

    public function paginate(int $perPage = 10): LengthAwarePaginator
    {
        return NotaryRelaasAkta::paginate($perPage);
    }

    public function find(int $id): ?NotaryRelaasAkta
    {
        return NotaryRelaasAkta::find($id);
    }

    public function create(array $data): NotaryRelaasAkta
    {
        return NotaryRelaasAkta::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $record = $this->find($id);
        return $record ? $record->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $record = $this->find($id);
        return $record ? (bool) $record->delete() : false;
    }

    public function searchByRegistrationCode(string $code, int $perPage = 10): LengthAwarePaginator
    {
        return NotaryRelaasAkta::where('registration_code', 'like', "%$code%")
            ->paginate($perPage);
    }

    public function filterByStatus(string $status, int $perPage = 10): LengthAwarePaginator
    {
        return NotaryRelaasAkta::where('status', $status)
            ->paginate($perPage);
    }
}
