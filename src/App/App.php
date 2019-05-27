<?php
namespace App\App;

class App
{
    const DB_SGBD = 'mysql';
    const DB_HOST = 'host';
    const DB_DATABASE = 'database;charset=utf8';
    const DB_USER = 'login';
    const DB_PASSWORD = 'password';
    public static $db;
    const URL = "https://www.my-website.fr";

    static public function DB_Connect() : void
    {
        try {
            self::$db = new \PDO(
                self::DB_SGBD . ':host=' . self::DB_HOST . ';dbname=' . self::DB_DATABASE . ';',
                self::DB_USER,
                self::DB_PASSWORD,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING
                ]
            );
        } catch (\Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    static public function Debug($arg, $mode = 1) :void
    {
        echo '<div style="background: #fda500; padding: 5px; z-index: 1000">';
        $trace = debug_backtrace(); //Fonction prédéfinie qui retourne un array contenant des infos tel que la ligne et le fichier où est éxécuté la fonction

        echo 'Debug demandé dans le fichier ' . $trace[0]['file'] . ' à la ligne ' . $trace[0]['line'];

        if($mode == 1){
            echo '<pre>';
            print_r($arg);
            echo '</pre>';
        } else{
            var_dump($arg);
        }
        echo '</div>';

    }
}