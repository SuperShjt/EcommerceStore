<?php
 require_once("DBconnect.php");

class Cate extends Database{

    private $conn;

    public function __construct(){
        $this->conn=$this->connect();
       
    }
    public function insert($name){
        $stmt = $this->conn->prepare("INSERT INTO  categories (name) VALUE (?)");
        $stmt->bind_param("s",$name);
        $stmt->execute();
        $stmt->close();
    }

}



?>