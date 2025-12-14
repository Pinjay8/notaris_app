<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PicProcessRepositoryInterface;
use App\Models\PicProcess;

class PicProcessRepository implements PicProcessRepositoryInterface
{

    protected $model;

    public function __construct(PicProcess $model)
    {
        $this->model = $model;
    }

    public function all(array $filters = [])
    {
        $query = $this->model->query()->where('notaris_id', auth()->user()->notaris_id);

        if (!empty($filters['pic_document_id'])) {
            $query->where('pic_document_id', $filters['pic_document_id']);
        }

        return $query->latest()->paginate(10);
    }

    public function find($id)
    {
        return PicProcess::findOrFail($id);
    }

    public function create(array $data)
    {
        return PicProcess::create($data);
    }

    public function update($id, array $data)
    {
        $process = $this->find($id);
        $process->update($data);
        return $process;
    }

    public function delete($id)
    {
        $process = $this->find($id);
        return $process->delete();
    }
}
