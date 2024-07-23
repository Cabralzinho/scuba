<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model {
    protected $table = 'categories';

    // public static function addCategories(string $name) {
    //     return self::insert([
    //         'name' => $name
    //     ]);
    // }

    public static function getAll() {
        return self::all();
    }
}