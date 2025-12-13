<?php

namespace App\Repositories;

use App\Models\NotaryAktaTransaction;
use App\Repositories\Interfaces\NotaryAktaTransactionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class NotaryAktaTransactionRepository implements NotaryAktaTransactionRepositoryInterface
{
    // public function all(array $filters = [], int $perPage = 10)
    // {
    //     $query = NotaryAktaTransaction::with(['client', 'akta_type']);

    //     if (!empty($filters['status'])) {
    //         $query->where('status', $filters['status']);
    //     } else {
    //         $query->where('status', 'draft');
    //     }

    //     if (!empty($filters['client_code'])) {
    //         $query->where('client_code', 'like', '%' . $filters['client_code'] . '%');
    //     }

    //     return $query->latest()->paginate($perPage);
    // }

    public function all(array $filters = [], int $perPage = 10)
    {
        $query = NotaryAktaTransaction::with(['client', 'akta_type'])->where('notaris_id', auth()->user()->notaris_id);

        // Filter status: hanya jika ada value dan tidak kosong
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('status', $filters['status']);
        }

        // Filter client code
        if (!empty($filters['transaction_code'])) {
            $query->where('transaction_code', 'like', '%' . $filters['transaction_code'] . '%');
        }

        return $query->latest()->paginate($perPage);
    }

    public function find(int $id)
    {
        return NotaryAktaTransaction::with(['client', 'akta_type'])->findOrFail($id);
    }


    public function create(array $data)
    {

        // $data['status'] = 'draft';
        // $data['year'] = null;
        // $data['akta_number'] = null;
        // $data['akta_number_created_at'] = null;


        return NotaryAktaTransaction::create($data);
    }

    public function update(int $id, array $data)
    {
        $transaction = $this->find($id);
        $transaction->update($data);
        return $transaction;
    }

    public function delete(int $id)
    {
        return $this->find($id)->delete();
    }

    public function updateStatus(int $id, string $status)
    {
        $transaction = $this->find($id);
        $transaction->update(['status' => $status]);
        return $transaction;
    }
}
