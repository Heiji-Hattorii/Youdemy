<?php

class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $bdd = 'youdemy';
    protected function Connexion()
    {
        try {
            $connect = new PDO("mysql:host={$this->host};dbname={$this->bdd}", $this->user, $this->pass);
            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connect;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
