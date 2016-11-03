<?php

namespace App\Table;


use System\BaseController;

class TableController extends BaseController
{
    private $tableRepo;

    public function __construct()
    {
        $this->tableRepo = new TableRepository();
        if(!isset($_SESSION["server"]) && !isset($_SESSION["user"]) && !isset($_SESSION["password"])) {
            $_SESSION["msg"] = "Connection timeout, please reconnect";
            RedirectToUrl("/");
        }
    }

    public function index()
    {
        $database = $_GET["database"];
        $this->addParams("AllTables",$this->tableRepo->GetDatabaseTable($database));
        $this->addParams("Database",$database);
        $this->view("index");
    }
}