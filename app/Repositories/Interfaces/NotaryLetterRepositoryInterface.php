<?php


namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;
use App\Models\NotaryLetters;

interface NotaryLetterRepositoryInterface
{
    public function all(): Collection;
    public function find($id): ?NotaryLetters;
    public function create(array $data): NotaryLetters;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
