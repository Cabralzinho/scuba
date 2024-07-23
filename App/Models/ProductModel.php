<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Capsule\Manager as DB;

class ProductModel extends Model {
    protected $table = 'products';
    protected $fillable = ['name', 'description', 'price'];

    public function addProduct(string $name, string $description, float $price, array $images) {
        $product = null;

        DB::transaction(function () use (&$product, $name, $description, $price, $images) {
            $product = $this->create([
                'name' => $name,
                'description' => $description,
                'price' => $price
            ]);

            $imagesToSaveDb[] = [
                "path" => $images[0]["path"],
                "product_id" => $product["id"]
            ];

            $this->addImages($imagesToSaveDb);
        });

        return $product;
    }

    public function getProducts() {
        return ProductImagesModel::with("product")->get();
    }

    private function addImages(array $images) {
        return $this->images()->insert($images);
    }

    private function images() {
        return $this->hasMany(ProductImagesModel::class);
    }
}
