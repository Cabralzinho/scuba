<?php 

namespace App\Services\Categories;

use App\Models\CategoryModel;

class GetCategoriesService {
    public function __construct(private CategoryModel $categoryModel) {
        
    }

    public function get() {
        return $this->categoryModel::getAll();
    }
}