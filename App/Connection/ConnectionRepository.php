<?php
/**
 * Created by PhpStorm.
 * User: Kiran
 * Date: 11/1/2016
 * Time: 3:00 PM
 */

namespace App\Connection;


use PDO;
use PDOException;
use System\Repository;

class ConnectionRepository extends Repository
{
    public function GetAllConnections()
    {
        $sqlQuery = $this->GetSQLLiteConnection()->prepare("SELECT * FROM connection_setting");
        $sqlQuery->execute();

        return $sqlQuery->fetchAll(PDO::FETCH_ASSOC);
    }

    public function GetSQLLiteConnection()
    {
        $conn = null;
        try {
            $conn = new PDO('sqlite:data.sqlite');
        } catch (PDOException $e) {
            print 'Exception : ' . $e->getMessage();
        }

        return $conn;
    }

    public function TestConnection(Connection $connection)
    {
        try {

            $dsn = "mysql:host=$connection->server;port=$connection->port";
            $dbh = new PDO($dsn, $connection->user, $connection->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

            return "success";

        } catch (PDOException $e) {

            return "error";
        }
    }

    public function InsertConnection(Connection $connection)
    {
        try {

            $sql = "DELETE FROM connection_setting WHERE server = '$connection->server'";
            $this->GetSQLLiteConnection()->exec($sql);

            $sql = "INSERT INTO connection_setting(server, user, password, port, server_description) VALUES ('$connection->server','$connection->user','$connection->password','$connection->port','$connection->server_description')";

            $status = $this->GetSQLLiteConnection()->exec($sql);

            return true;

        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }

    }

    public function DeleteByServername($server)
    {
        try {
            $this->GetSQLLiteConnection()->exec("DELETE FROM connection_setting WHERE server = '$server'");
            return true;
        } catch (PDOException $exception) {
            return false;
        }
    }

    public function ConnectionProcess($server)
    {
        try {
            $sqlQuery = $this->GetSQLLiteConnection()->query("SELECT * FROM connection_setting WHERE server = '$server'");
            $result = $sqlQuery->fetchAll(PDO::FETCH_ASSOC);

            if(isset($result[0])) {
                $_SESSION["server"] = $result[0]["server"];
                $_SESSION["user"] = $result[0]["user"];
                $_SESSION["password"] = $result[0]["password"];
                $_SESSION["port"] = $result[0]["port"];

                return true;
            }

            return false;

        } catch (PDOException $exception) {
            return false;
        }
    }

}