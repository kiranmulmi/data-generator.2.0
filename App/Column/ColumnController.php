<?php

namespace App\Column;


use System\BaseController;

class ColumnController extends BaseController
{
    private $columnRepo;

    public function __construct()
    {
        $this->columnRepo = new ColumnRepository();
        if (!isset($_SESSION["server"]) && !isset($_SESSION["user"]) && !isset($_SESSION["password"])) {
            $_SESSION["msg"] = "Connection timeout, please reconnect";
            RedirectToUrl("/");
        }
    }

    public function index()
    {
        $database = $_GET["database"];
        $table = $_GET["table"];

        $this->addParams("AllTables", $this->columnRepo->GetDatabaseTable($database));
        $this->addParams("Database", $database);
        $this->addParams("Table", $table);
        $this->addParams("AllColumn", $this->columnRepo->GetDatabaseTableColumn($database, $table));

        //dd( $this->columnRepo->GetDatabaseTableColumn($database, $table));
        $this->view("index");
    }
}