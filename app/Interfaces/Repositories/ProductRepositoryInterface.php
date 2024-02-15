<?php

namespace App\Interfaces\Repositories;

interface ProductRepositoryInterface extends ReadRepositoryInterface, CUDRepositoryInterface
{
    public function getByCategory($id);
    public function getProductCategories();
}
