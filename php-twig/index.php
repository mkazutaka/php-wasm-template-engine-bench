<?php

declare(strict_types = 1);
require __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$loader = new FilesystemLoader(__DIR__ . '/../templates');
$twig = new Environment($loader);

echo $twig->render('index.html.twig',
    [
        'name' => 'John Doe',
        'occupation' => 'gardener'
    ]
);

