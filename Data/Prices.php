<?php
require_once("DBconnect.php");

class price extends Database{
    
    private $conn;

    public function __construct(){
        $this->conn=$this->connect();
    }
    public function insert($p_id,$amount){
        $stmt = $this->conn->prepare("INSERT INTO prices (product_id, amount) VALUES (?, ?)");
        $stmt->bind_param("sd",$p_id,$amount);
        $stmt->execute();
        $stmt->close();

    }
    private function getPriceID($pro_id){
        $stmt = $this->conn->prepare("SELECT id FROM prices where product_id = ?");
        $stmt->bind_param("s",$pro_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['id'] ?? null;

    }
    public function insert_currency($prox,$label,$symbol){
        $result= $this->getPriceID($prox);
        $stmt = $this->conn->prepare("INSERT INTO currency (label, symbol, price_id) VALUES (?, ?, ? )");
        $stmt->bind_param("ssi",$label,$symbol,$result);
        $stmt->execute();
        $stmt->close();
        
    }


    




}