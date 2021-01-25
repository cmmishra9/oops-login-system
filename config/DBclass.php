<?php
// define("DB_SERVER","localhost");
// define("DB_USERNAME","root");
// define("DB_PWD","");
// define("DB_NAME", "loginsystem");

class DBClass{

    private $server;
    private $username;
    private $pass;
    private $dbname='';

    public function __construct($servername, $username, $pass, $dbname=""){

        $this->server = $servername;
        $this->username= $username;
        $this->pass = $pass;
        $this->dbname=$dbname;
        $this->dbConnect();
    }

    protected function dbConnect(){
        try{

            $link = new PDO( "mysql:host=".$this->server.";
                              dbname=".$this->dbname, 
                              $this->username, $this->pass
                            );
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $link;                
        
        } catch (Exception $e){
           return die("ERROR: Could not connect. " . $e->getMessage());
        }

    }
}