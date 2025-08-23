<?php

namespace App\Repositories;

use App\Models\NotaryRelaasLogs;
use App\Repositories\Interfaces\NotaryRelaasLogsRepositoryInterface;

class NotaryRelaasLogsRepository implements NotaryRelaasLogsRepositoryInterface
{
    public function getAll()
    {
        return NotaryRelaasLogs::with(['notaris', 'client'])->latest()->paginate(10);
    }

    public function findById(int $id): ?NotaryRelaasLogs
    {
        return NotaryRelaasLogs::find($id);
    }

    public function create(array $data): NotaryRelaasLogs
    {
        return NotaryRelaasLogs::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $log = NotaryRelaasLogs::findOrFail($id);
        return $log->update($data);
    }

    public function delete(int $id): bool
    {
        $log = NotaryRelaasLogs::findOrFail($id);
        return $log->delete();
    }
}
