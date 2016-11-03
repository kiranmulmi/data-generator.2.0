<?php
/**
 * Created by PhpStorm.
 * User: Kiran
 * Date: 11/1/2016
 * Time: 3:00 PM
 */

namespace App\Database;


use App\Connection\Connection;
use PDO;
use PDOException;
use System\Repository;

class DatabaseRepository extends Repository
{
    public function GetServerDatabases()
    {

        $sql = "show databases";
        $sqlQuery = $this->GetConnectedServerConnection()->query($sql);
        $databases = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);

        $not_allowed_db = array("information_schema", "performance_schema", "sys","data_generator","mysql");

        $database_sorted = array();
        foreach ($databases as $database) {
            if (!in_array($database["Database"], $not_allowed_db)) {
                $database_sorted[] = $database["Database"];
            }
        }

        sort($database_sorted);

        return $database_sorted;

    }

    public function GetConnectedServerConnection()
    {
        $conn = null;
        $connection = new Connection();
        $connection->Map($_SESSION);
        try {
            $conn = new PDO("mysql:host=$connection->server;port=$connection->port", $connection->user, $connection->password);
        } catch (PDOException $e) {
            $_SESSION["message"] = "Unable to connect to database server";
            RedirectToUrl('/');
        }

        return $conn;
    }



}