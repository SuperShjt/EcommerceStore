<?php

require_once("DBconnect.php");
 class  Gallery extends Database{

    private $conn;

    public function __construct(){

        $this->conn=$this->connect();
    }
    public function insert($pid,$url){
        $stmt = $this->conn->prepare("INSERT INTO product_gallery (product_id, img_url) VALUES (?, ?)");
        $stmt->bind_param("ss",$pid,$url);
        $stmt->execute();
        $stmt->close();
    }







}