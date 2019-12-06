<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig
{
    /** @var Environment */
    private $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader(__DIR__ . '/../templates');
        $this->twig = new Environment($loader);
    }

    public function renderHello(): string
    {
        return $this->twig->render('index.html.twig', []);
    }

    public function renderBench(): string
    {
        return $this->twig->render('bench.html.twig', [
            'title' => 'this is title'
        ]);
    }
}
