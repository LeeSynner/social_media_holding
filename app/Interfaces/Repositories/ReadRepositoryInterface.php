<?php

namespace App\Interfaces\Repositories;

interface ReadRepositoryInterface
{
    public function getAll();
    public function getById($id);
    public function search($q);
}
