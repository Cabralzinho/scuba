<?php

namespace App\Services\Products;

use App\Models\ProductModel;

class GetProductsService {

    public function __construct(ProductModel $model) {}

    public function get() {
        $model = new ProductModel();
        return $model->getProducts();
    }
}