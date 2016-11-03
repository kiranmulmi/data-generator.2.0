<?php

namespace App\Generator;


class GeneratorRepository
{
    public function Preview()
    {

    }

    public function Generate()
    {

    }

    public function GetConnectedServerConnection($database = null)
    {
        $conn = null;
        $connection = new Connection();
        $connection->Map($_SESSION);
        try {
            if($database != null) {
                $conn = new PDO("mysql:host=$connection->server;dbname=$database;port=$connection->port", $connection->user, $connection->password);
            } else {
                $conn = new PDO("mysql:host=$connection->server;port=$connection->port", $connection->user, $connection->password);
            }
        } catch (PDOException $e) {
            $_SESSION["message"] = "Unable to connect to database server";
            RedirectToUrl('/');
        }

        return $conn;
    }
}