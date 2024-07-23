<?php

namespace App;

class TemplateEngine {
    private $twig;

    public function __construct() {
        $loader = new \Twig\Loader\FilesystemLoader(['../App/Views/']);
        $this->twig = new \Twig\Environment($loader);
    }

    public function render($template, $data = []): string {
        $data["session"] = $_SESSION["user"] ?? null;

        return $this->twig->render("Pages/$template.twig", $data);
    }
}