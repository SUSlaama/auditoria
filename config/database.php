<?php

class Database{
    private $hostname = "sql204.infinityfree.com";
    private $database = "if0_37860573_m3racha";
    private $username = "if0_37860573";
    private $password = "Vitacore05";
    private $charset = "utf8";


    function conectar(){

        try {
            $conexion = "mysql:host=" . $this->hostname . "; dbname=" . $this->database . 
            "; charset" . $this->charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $pdo = new PDO($conexion, $this->username, $this->password, $options);
            return $pdo;
        } catch(PDOException $e){
            echo 'Error conexion: ' . $e->getMessage();
            exit;
        }
    }
    
}





?>