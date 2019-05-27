<?php
namespace App\Controller;

use App\App\App;
use App\Router\Router;
use App\Agences\Agences;
use App\Mailer\Mailer;

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

    static public function envoiMail() : void
    {
        $agences = Agences::recup(0);
        App::Debug($agences);

        $texte = file_get_contents(__DIR__ . '/../../public/assets/texte/agence.txt');
        $joints = [
            'pdf/cv.pdf',
            'pdf/attestation.pdf'
        ];

        foreach($agences as $a){
            if(Mailer::envoi($a['mail'], $texte, $joints)){
                
                $update = App::$db->prepare('UPDATE agence SET envoi = 1 WHERE id_agence = :id');
                $update->execute(['id' => $a['id_agence']]);

                echo '<br>Envoi ok : ' . $a['mail'];
            }
        }
    }
}