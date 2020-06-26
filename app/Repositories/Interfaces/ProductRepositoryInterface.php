<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function insertOrUpdateArray($data);

    public function createProductImage($imageFile, $title, $product);

    public function createProductPreviewImage($imageFile, $title, $product);

    public function getAllProduct();

    public function storeProduct($data);

    public function updateProduct($product, $data);
}

