<?php
namespace App\Controller;

use App\App\App;
use App\Router\Router;
use App\Agences\Agences;

class HomeController extends AbstractController
{
    static public function home() : void
    {
        if($_POST && isset($_POST['ajout'])){
            if(Agences::ajout($_POST['nom'] ?? '', $_POST['mail'] ?? '')){
                header('location:' . App::URL);
                die;
            }
        }

        $agences = Agences::recup();

        self::twig(
            'home.html',
            [
                'HTML_TITLE' => "Accueil | Pay-Able",
                'AGENCES' => $agences,
                'POST' => [
                    'nom' => $_POST['nom'] ?? '',
                    'mail' => $_POST['mail'] ?? '',
                ]
            ]
        );
    }
}