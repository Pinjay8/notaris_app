<?php

namespace App\Repositories;

use App\Models\PicStaff;
use App\Repositories\Interfaces\PicStaffRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PicStaffRepository implements PicStaffRepositoryInterface
{
    public function all(?string $search = null): Collection
    {
        $query = PicStaff::query();

        if ($search) {
            $query->where('full_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        return $query->latest()->get();
    }

    public function find(int $id): ?PicStaff
    {
        return PicStaff::find($id);
    }

    public function create(array $data): PicStaff
    {
        return PicStaff::create($data);
    }

    public function update(PicStaff $picStaff, array $data): bool
    {
        return $picStaff->update($data);
    }

    public function delete(PicStaff $picStaff): bool
    {
        return $picStaff->delete();
    }
}
