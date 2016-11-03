<?php

namespace App\Connection;


use System\BaseModel;

class Connection extends BaseModel
{
    public $server_description;
    public $server;
    public $user;
    public $port;
    public $password;
}