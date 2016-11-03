<?php

namespace App\Connection;


use System\BaseController;

class ConnectionController extends BaseController
{
    private $connectionRepo;

    public function __construct()
    {
        $this->connectionRepo = new ConnectionRepository();
    }

    public function index()
    {

        $this->addParams("Connection",$this->connectionRepo->GetAllConnections());
        $this->view("index");
    }

    public function validate()
    {
        $connection = new Connection();
        $connection->Map($_POST);
        $status = $this->connectionRepo->TestConnection($connection);
        echo $status;
    }

    public function add()
    {
        $connection = new Connection();
        $connection->Map($_POST);

        $status = $this->connectionRepo->InsertConnection($connection);
        $_SESSION["msg"] = "Connection successfully added";
        RedirectToUrl("/");
    }

    public function delete()
    {
        $server = $_GET["server"];
        $status = $this->connectionRepo->DeleteByServername($server);
        $_SESSION["msg"] = "Connection deleted";
        RedirectToUrl("/");
    }

    public function connect()
    {
        $server = $_GET["server"];
        $status = $this->connectionRepo->ConnectionProcess($server);

        if($status) {
            RedirectToUrl("/available-databases");
        } else {
            $_SESSION['msg'] = "Unable to connect";
        }
    }

    public function logout()
    {
        if(isset($_SESSION["server"])) {
            unset($_SESSION["server"]);
        }

        if(isset($_SESSION["user"])) {
            unset($_SESSION["user"]);
        }

        if(isset($_SESSION["password"])) {
            unset($_SESSION[""]);
        }

        if(isset($_SESSION["port"])) {
            unset($_SESSION["port"]);
        }

        $_SESSION['msg'] = "Logout successful";

        RedirectToUrl("/");
    }
}