<?php

namespace App\Repositories\Interfaces;

interface NotaryAktaLogRepositoryInterface
{
    public function all(array $filters = []);
    public function getById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}