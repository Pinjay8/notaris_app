<?php

namespace App\Repositories;

use App\Repositories\Interfaces\DocumentRepositoryInterface;
use App\Models\Documents;


class DocumentRepository implements DocumentRepositoryInterface
{
    public function all(string $status = '1')
    {
        $query = Documents::query();

        if ($status === '1') {
            $query->where('status', 1); // hanya aktif
        } elseif ($status === '0') {
            $query->where('status', 0); // hanya nonaktif
        }
        // jika 'all', tampilkan semua

        return $query->get();
    }

    public function search(string $keyword, string $status = '1')
    {
        $query = Documents::where(function ($q) use ($keyword) {
            $q->where('code', 'like', "%{$keyword}%")
                ->orWhere('name', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%");
        });

        if ($status === '1') {
            $query->where('status', 1);
        } elseif ($status === '0') {
            $query->where('status', 0);
        }

        return $query->get();
    }

    public function create(array $data): Documents
    {
        return Documents::create($data);
    }

    public function update(Documents $document, array $data): Documents
    {
        $document->update($data);
        return $document;
    }

    public function deactivate(Documents $document): bool
    {
        $document->status = false;
        return $document->save();
    }

    public function find(int $id): ?Documents
    {
        return Documents::find($id);
    }
}
