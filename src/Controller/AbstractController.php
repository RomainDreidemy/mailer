<?php

namespace App\Controller;

use App\App\App;
use App\Message\Message;


abstract class AbstractController
{
    // Rendu de template twig
    static protected function twig(string $template, array $arguments = [])
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../../templates/');
        $twig = new \Twig_Environment($loader, []);

        $app = [
            'SESSION_USER' => $_SESSION['user'] ?? [],
            'MESSAGES_ERREUR' => Message::show(),
            '_FRONT' => App::URL,
            'SESSION' => $_SESSION
        ];

        $arguments = array_merge($arguments, $app);

        $twig->display($template, $arguments);
    }
}