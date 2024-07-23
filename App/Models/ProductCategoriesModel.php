<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategoriesModel extends Model {
    protected $table = 'products_categories';

    public static function addCategories(array $categories) {
        return self::insert($categories);
    }
}