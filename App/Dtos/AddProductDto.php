<?php

namespace App\Dtos;
use App\Exceptions\InvalidBodyFieldException;
use Psr\Http\Message\UploadedFileInterface;

class AddProductDto {

    public function __construct(
        public $name,
        public $description,
        public $price,
        public $images = []
    ) {
        $this->validateData();
    }

    private function validateData() {
        $this->validateName();
        $this->validateDescription();
        $this->validatePrice();
        $this->validateImages();
    }

    private function validateName() {
        if (!is_string($this->name)) {
            throw new InvalidBodyFieldException('O campo nome deve ser uma string.');
        }
    }

    private function validateDescription() {
        if (!is_string($this->description)) {
            throw new InvalidBodyFieldException('O campo Descrição deve ser uma string');
        }
    }

    private function validatePrice() {
        if (!is_numeric($this->price)) {    
            throw new InvalidBodyFieldException('O preço deve ser um número');
        }

        $this->price = floatval($this->price);
    }

    public function validateImages() {
        foreach ($this->images as $image) {
            if (!$image instanceof UploadedFileInterface) {
                throw new InvalidBodyFieldException("O arquivo enviado não é válido");
            }

            $allowedMimeTypes = ["image/jpeg", "image/png"];

            if (in_array($image->getClientMediaType(), $allowedMimeTypes) === false) {
                throw new InvalidBodyFieldException("O formato do arquivo não é válido");
            }
        }
    }
}
