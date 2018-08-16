<?php

require_once 'Config.php';

abstract class Connection
{

    public function conectDB()
    {
            try {
                $con = new PDO('mysql:host=' . HOST . ';dbname=' . BASE, USER, PASS );
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $con;

            } catch (PDOException $erro) {
                var_dump($erro->getMessage());
            }

    }

}