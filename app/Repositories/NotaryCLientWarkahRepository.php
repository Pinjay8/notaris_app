<?php

namespace App\Repositories;

use App\Models\NotaryClientWarkah;
use App\Repositories\Interfaces\NotaryClientWarkahRepositoryInterface;
use Illuminate\Support\Facades\Log;

class NotaryClientWarkahRepository implements NotaryClientWarkahRepositoryInterface
{

    public function getByCompositeKey(array $keys)
    {
        return NotaryClientWarkah::where('registration_code', $keys['registration_code'])
            ->where('notaris_id', $keys['notaris_id'])
            ->where('client_id', $keys['client_id'])
            ->where('product_id', $keys['product_id'])
            ->get();
    }

    public function createWarkah(array $keys, array $data)
    {
        $dataToCreate = array_merge($keys, [
            'warkah_code'  => $data['warkah_code'], // ambil dari product_document
            'warkah_name'  => $data['warkah_name'],
            'note'           => $data['note'],
            'warkah_link'  => $data['warkah_link'],
            'uploaded_at'    => $data['uploaded_at'],
            'status'         => $data['status'],
        ]);

        return NotaryClientWarkah::create($dataToCreate);
    }


    public function findByCompositeKey(array $keys)
    {
        return NotaryClientWarkah::where('registration_code', $keys['registration_code'])
            ->where('notaris_id', $keys['notaris_id'])
            ->where('client_id', $keys['client_id'])
            ->where('product_id', $keys['product_id'])
            ->firstOrFail();
    }



    public function updateStatusByCompositeKey(array $keys, string $status)
    {
        $product = $this->findByCompositeKey($keys);
        $product->status = $status;
        $product->save();
        return $product;
    }
}
