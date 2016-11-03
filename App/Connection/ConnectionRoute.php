<?php
/*
 | structure
 |-----------------------------
 | URL => Controller@Action
 |
 | */

return [
    "/" => "ConnectionController@index",
    "/connection/validate" => "ConnectionController@validate",
    "/connection/add" => "ConnectionController@add",
    "/connection/delete" => "ConnectionController@delete",
    "/connection/connect" => "ConnectionController@connect",
    "/connection/logout" => "ConnectionController@logout",
];