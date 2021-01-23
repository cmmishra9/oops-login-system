<?php

define("DB_SERVER","localhost");
define("DB_USERNAME","root");
define("DB_PWD","");
define("DB_NAME", "loginsystem");

$link = new mysqli(DB_SERVER, DB_USERNAME, DB_PWD, DB_NAME);

if($link=== false){
    die("Error: Could Not Connect. ". $link->connect_error);
}