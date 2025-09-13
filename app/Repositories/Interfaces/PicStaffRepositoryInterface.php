<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use App\Models\PicStaff;

interface PicStaffRepositoryInterface
{
    public function all(?string $search = null): Collection;
    public function find(int $id): ?PicStaff;
    public function create(array $data): PicStaff;
    public function update(PicStaff $picStaff, array $data): bool;
    public function delete(PicStaff $picStaff): bool;
}