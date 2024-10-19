<?php

class Database {

    private $dbname ="ecomm" ;
    private $pass= "";
    private $sername="localhost";
    private $Dbuser="root";
    private $conn;

    public function connect(){

        $this->conn = mysqli_connect($this->sername,$this->Dbuser,$this->pass,$this->dbname);

        if(!$this->conn){
            die("Connection failed: ". mysqli_connect_error());
        }
        else{

            echo "Works like magic <br>";
            return $this->conn;
        }
        
    }

}


?>