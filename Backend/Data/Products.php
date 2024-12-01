<?php

require_once("DBconnect.php");
class Products extends Database{

    private $conn;
    public function __construct(){

        $this->conn=$this->connect();
    }

    public function getcatid($catID){
        
        $stmt = $this->conn->prepare("SELECT id FROM categories where name = ?");
        $stmt->bind_param("s",$catID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['id'] ?? null;
    }
    

    public function insert($id,$name,$inStock,$desc,$catid,$brand){

        $catx = $this->getcatid($catid);
        $stmt = $this->conn->prepare("INSERT INTO products ( id, name, inStock, Des, category_id, brand) VALUES (?, ?, ?, ?, ?, ?) ");
        $stmt->bind_param("ssisis",$id,$name,$inStock,$desc,$catx,$brand);
        $stmt->execute();
        $stmt->close();
    }


}