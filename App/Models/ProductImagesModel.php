<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImagesModel extends Model {
    protected $table = 'products_images';

    public function product() {
        return $this->belongsTo(ProductModel::class, "product_id");
    }
}