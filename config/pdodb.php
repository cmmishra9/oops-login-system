<?php
define("DB_SERVER","localhost");
define("DB_USERNAME","root");
define("DB_PWD","");
define("DB_NAME", "loginsystem");

try{

    $link = new PDO( "mysql:host=".DB_SERVER.";
                      dbname=".DB_NAME, 
                      DB_USERNAME, DB_PWD
                    );
    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                

} catch (Exception $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}