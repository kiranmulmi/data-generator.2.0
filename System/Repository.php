<?php

namespace System;


use PDO;
use PDOException;
use Setting\Database;

class Repository
{
    public function GetDbConnection() {
        $database = new Database();
        $connectionParameter = $database->ConnectionParameter();

        $dbh = new PDO("mysql:host={$connectionParameter["Server"]};dbname={$connectionParameter["Database"]}",$connectionParameter["User"],$connectionParameter["Password"],array(
            \PDO::MYSQL_ATTR_LOCAL_INFILE => true));

        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);

        $dbh->exec("USE {$connectionParameter['Database']}");
        return $dbh;
    }

    public function Get($table) {

        $sql = "SELECT * FROM {$table}";
        $result = $this->GetDbConnection()->prepare($sql);

        $result->execute();

        return $result->fetchAll(\PDO::FETCH_OBJ);
    }

    public function Insert($model, $removeFields = array(), $table)
    {
        try {

            $modelArray = (array)$model;


            foreach ($removeFields as $removeField) {
                unset($modelArray[$removeField]);
            }

            $insertSql = "INSERT INTO `{$table}` (";

            $keys = array_keys($modelArray);

            $insertSql .= '`' . implode('`,`', $keys) . '`' . ") ";

            $insertSql .= "VALUES(";

            $insertSql .= ":" . implode(',:', $keys) . ")";

            $sqlQuery = $this->GetDbConnection()->prepare($insertSql);

            foreach ($modelArray as $key => $value) {
                $sqlQuery->bindValue(":" . $key, $value);
            }

            $sqlQuery->execute();


            $queryID = $this->GetDbConnection()->prepare("SELECT MAX(ID) FROM {$table}");
            $queryID->execute();

            return $queryID->fetchColumn();

        } catch (PDOException $e) {

            print "Error!: " . $e->getMessage() . "</br>";
        }

    }

    public function UpdateTable($model, $removeFields, $table, $id = null, $updateFrom = null, $updateFromValue = null)
    {
        $modelArray = (array)$model;

        foreach ($removeFields as $removeField) {
            unset($modelArray[$removeField]);
        }

        $updateSql = "UPDATE `{$table}` SET ";

        $keys = array_keys($modelArray);

        foreach ($keys as $key) {
            $updateSql .= "`$key`=:$key,";
        }

        $updateSql = rtrim($updateSql, ',');

        if ($updateFrom == null) {
            if ($id == null)
                $updateSql .= " WHERE ID=:ID";
            else
                $updateSql .= " WHERE $id=:$id";
        } else
            $updateSql .= " WHERE $updateFrom=:$updateFrom";


        $sqlQuery = $this->GetDbConnection()->prepare($updateSql);

        if ($updateFrom == null) {
            if ($id == null)
                $sqlQuery->bindValue(":ID", $model->ID);
            else
                $sqlQuery->bindValue(":$id", $model->$id);
        } else
            $sqlQuery->bindValue(":$updateFrom", $updateFromValue);

        foreach ($modelArray as $key => $value) {
            $sqlQuery->bindValue(":" . $key, $value);
        }

        $sqlQuery->execute();
    }

    public function Delete($id,$table,$delColumn=null) {

        $col = "ID";
        if($delColumn != null) {
            $col = $delColumn;
        }
        $sql = "DELETE FROM {$table} WHERE $col = {$id}";
        $result = $this->GetDbConnection()->prepare($sql);
        $result->execute();
        return true;
    }

    public function GetCurrentDateTime()
    {
        $sqlQuery = $this->GetDbConnection()->query("SELECT CURRENT_TIMESTAMP");
        $datetime = $sqlQuery->fetchColumn();
        return $datetime;
    }
}