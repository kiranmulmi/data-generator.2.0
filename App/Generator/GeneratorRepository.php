<?php

namespace App\Generator;

use App\Connection\Connection;
use PDO;
use PDOException;

class GeneratorRepository
{
    public function GetForeignKeyData($database, $table, $column)
    {
        try {
            $sql = "SELECT `{$column}` FROM `$table`";
            $sqlQuery = $this->GetConnectedServerConnection($database)->prepare($sql);
            $sqlQuery->execute();

            return $sqlQuery->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {

        }
    }

    public function GetConnectedServerConnection($database = null)
    {
        $conn = null;
        $connection = new Connection();
        $connection->Map($_SESSION);
        try {
            if($database != null) {
                $conn = new \PDO("mysql:host=$connection->server;dbname=$database;port=$connection->port", $connection->user, $connection->password);
            } else {
                $conn = new \PDO("mysql:host=$connection->server;port=$connection->port", $connection->user, $connection->password);
            }
        } catch (PDOException $e) {
            $_SESSION["message"] = "Unable to connect to database server";
            RedirectToUrl('/');
        }

        return $conn;
    }
}