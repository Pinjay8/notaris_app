<?php


namespace App\Repositories\Interfaces;

interface PicDocumentsRepositoryInterface
{
    public function getAll($filters = []);
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
