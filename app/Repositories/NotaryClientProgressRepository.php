<?php

namespace App\Repositories;

use App\Models\NotaryClientProgress;
use App\Repositories\Interfaces\NotaryClientProgressRepositoryInterface;

class NotaryClientProgressRepository implements NotaryClientProgressRepositoryInterface
{
    public function getByCompositeKey(array $keys)
    {
        return NotaryClientProgress::where('registration_code', $keys['registration_code'])
            ->where('notaris_id', $keys['notaris_id'])
            ->where('client_id', $keys['client_id'])
            ->where('product_id', $keys['product_id'])
            ->orderByDesc('progress_date')
            ->get();
    }

    public function createProgress(array $keys, array $data)
    {
        $dataToCreate = array_merge($keys, [
            'progress' => $data['progress'],
            'progress_date' => $data['progress_date'] ?? now(),
            'note' => $data['note'] ?? '',
            'status' => $data['status'] ?? '',
        ]);
        return NotaryClientProgress::create($dataToCreate);
    }
}
