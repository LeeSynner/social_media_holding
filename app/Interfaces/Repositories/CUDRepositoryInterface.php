<?php

namespace App\Interfaces\Repositories;

interface CUDRepositoryInterface
{
    public function create($data);
    public function update($id, $data);
    public function delete($id);
}
