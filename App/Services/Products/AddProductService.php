<?php

namespace App\Services\Products;

use App\Dtos\AddProductDto;
use App\Models\ProductImagesModel;
use App\Models\ProductModel;

class AddProductService {
    private $imagesDetails = [];

    public function __construct(private ProductModel $productModel) {
    }

    public function execute(AddProductDto $dto) {
        $this->prepareImageToSave($dto->images);

        $product = $this->productModel->addProduct($dto->name, $dto->description, $dto->price, [
            [
                "path" => $this->imagesDetails[0]["path"],
            ]
        ]);

        $this->saveImagesFilesInFolder($this->imagesDetails);

        return $product;
    }

    private function saveImagesFilesInFolder(array $images) {
        foreach ($images as $image) {
            $image["file"]->moveTo("../App/Uploads/products" . $image["path"]);
        }
    }

    private function prepareImageToSave(array $images) {
        foreach ($images as $image) {
            $extension = pathinfo($image->getClientFilename(), PATHINFO_EXTENSION);
            $path = "/" . uniqid() . "." . $extension;

            $this->imagesDetails[] = [
                "path" => $path,
                "file" => $image
            ];
        }
    }
}
