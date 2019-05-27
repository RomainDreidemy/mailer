<?php
namespace App\Agences;

use App\Message\Message;
use App\App\App;

Class Agences
{
    public static function ajout($nom, $mail) : bool
    {
        $errors = [
            'Tous les champs doivent être remplis' => empty(trim($nom)) || empty(trim($mail)),
            'Ceci n\'est pas une adresse email' => !preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $mail)
        ];

        if(in_array(true, $errors)){
            Message::add(Message::MSG_ERROR, array_search(true, $errors));
            return false;
        }

        $select = App::$db->prepare('SELECT * FROM agence WHERE mail = :mail');
        $select->execute(['mail' => $mail]);

        if($select->rowCount() != 0){
            Message::add(Message::MSG_ERROR, 'L\'adresse mail est déjà dans la base de donnée');
            return false;
        }

        $insert = App::$db->prepare('INSERT INTO agence(nom, mail) VALUES(:nom, :mail)');
        $requete = $insert->execute([
            'nom' => $nom,
            'mail' => $mail
        ]);

        if(!$requete){
            Message::add(Message::MSG_ERROR, 'La requête SQL a échoué');
            return false;
        }

        Message::add(Message::MSG_SUCCESS, 'L\'agence a été ajouté à la base de donnée');
        return true;
    }

    public static function recup($param = NULL) : array
    {
        /* $param :
        * NULL = ALL
        * 0 = non envoyé
        * 1 = envoyé
        */

        // Si $param est null
        if(is_null($param)){
            $select = App::$db->query('SELECT * FROM agence ORDER BY envoi ASC, id_agence DESC');
            return $select->fetchAll(\PDO::FETCH_ASSOC) ?? [];
        }

        // Si $param n'est pas nul
        $select = App::$db->prepare('SELECT * FROM agence WHERE envoi = :envoi');
        $select->execute(['envoi' => $param]);
        return $select->fetchAll(\PDO::FETCH_ASSOC) ?? [];
    }
}