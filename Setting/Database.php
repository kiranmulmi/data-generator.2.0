<?php

namespace Setting;


class Database
{
    public function ConnectionParameter() {

        return array(
            "ServerType" => "MySQL",
            "Server" => "localhost",
            "User" => "root",
            "Password" => "",
            "Database" => "",

        );
    }
}