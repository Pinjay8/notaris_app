<?php

namespace App\Repositories\Interfaces;

interface PicHandoverRepositoryInterface
{
    public function all(array $filters = []);
    public function find($id);
    public function create(array $data);
    public function delete($id);
}
