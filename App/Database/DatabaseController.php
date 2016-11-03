<?php

namespace App\Database;


use System\BaseController;

class DatabaseController extends BaseController
{
    private $databaseRepo;

    public function __construct()
    {
        $this->databaseRepo = new DatabaseRepository();
        if(!isset($_SESSION["server"]) && !isset($_SESSION["user"]) && !isset($_SESSION["password"])) {
            $_SESSION["msg"] = "Connection timeout, please reconnect";
            RedirectToUrl("/");
        }
    }

    public function index()
    {
        $this->addParams("AllDatabase",$this->databaseRepo->GetServerDatabases());
        $this->view("index");
    }
}