<?php

namespace App\Exceptions;

class InvalidBodyFieldException extends \Exception {
    public function __construct(public string $error = "") {
        parent::__construct($error);
    }
}