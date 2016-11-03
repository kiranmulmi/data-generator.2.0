<?php
namespace System;


class BaseModel
{
    public function Map($arr)
    {
        $arr = (array)$arr;
        $modelsObj = get_object_vars($this);
        $modelsArr = (array) $modelsObj;

        foreach($modelsArr as $modelKey => $modelVal) {
            $this->{$modelKey} = null;
            if(isset($arr[$modelKey]) && !empty($arr[$modelKey])) {
                $this->{$modelKey} = $this->Clean($arr[$modelKey]);
            }
        }
    }

    private function Clean($clean)
    {
        $clean = trim($clean);
        $clean = htmlentities($clean);
        $clean = stripslashes($clean);
        return $clean;
    }

    public function GetByID($id, $table) {
        $sql = "SELECT * FROM {$table} WHERE ID = {$id}";
        //echo $sql;exit;
        $repository = new Repository();
        $result = $repository->GetDbConnection()->prepare($sql);
        $result->execute();
        $arr = $result->fetchAll(\PDO::FETCH_OBJ);
        if(isset($arr[0])) {
            $this->Map($arr[0]);
        }

    }
}