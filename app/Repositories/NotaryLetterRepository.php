<?php

namespace App\Repositories;

use App\Models\NotaryLetter;
use App\Models\NotaryLetters;
use App\Repositories\Interfaces\NotaryLetterRepositoryInterface;
use Illuminate\Support\Collection;

class NotaryLetterRepository implements NotaryLetterRepositoryInterface
{
    public function all(?string $search = null)
    {
        return NotaryLetters::with(['notaris', 'client'])
            ->when($search, function ($query, $search) {
                $query->where('letter_number', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);
    }

    public function find($id): ?NotaryLetters
    {
        return NotaryLetters::with(['notaris', 'client'])->find($id);
    }

    public function create(array $data): NotaryLetters
    {
        return NotaryLetters::create($data);
    }

    public function update($id, array $data): bool
    {
        $notaryLetter = $this->find($id);
        return $notaryLetter->update($data);
    }

    public function delete($id): bool
    {
        $notaryLetter = $this->find($id);
        return $notaryLetter->delete();
    }
}
