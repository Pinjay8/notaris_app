<?php

namespace App\Repositories;

use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientRepository implements ClientRepositoryInterface
{
    public function all(): Collection
    {
        return Client::all();
    }

    public function findById(int $id): ?Client
    {
        return Client::withTrashed()->find($id);
    }

    public function getByNotaryId(int $notaryId): Collection
    {
        return Client::where('notaris_id', $notaryId)->get();
    }

    public function search(array $filters): LengthAwarePaginator
    {
        $query = Client::query();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('fullname', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('nik', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->paginate(2);
    }

    public function create(array $data): Client
    {
        return Client::create($data);
    }

    public function update(int $id, array $data): Client
    {
        $client = Client::findOrFail($id);
        $client->update($data);

        return $client;
    }

    public function delete(int $id): bool
    {
        $client = Client::findOrFail($id);
        return $client->delete();
    }

    public function restore(int $id): bool
    {
        return Client::withTrashed()->findOrFail($id)->restore();
    }

    public function forceDelete(int $id): bool
    {
        return Client::withTrashed()->findOrFail($id)->forceDelete();
    }
}
