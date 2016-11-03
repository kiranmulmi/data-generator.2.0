<?php
/**
 * Created by PhpStorm.
 * User: Kiran
 * Date: 11/1/2016
 * Time: 3:00 PM
 */

namespace App\Table;


use App\Connection\Connection;
use PDO;
use PDOException;
use System\Repository;

class TableRepository extends Repository
{
    public function GetDatabaseTable($database)
    {
        $sql = "SHOW TABLES";
        $result = $this->GetConnectedServerConnection($database)->query($sql);
        return $result->fetchAll(PDO::FETCH_COLUMN);
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