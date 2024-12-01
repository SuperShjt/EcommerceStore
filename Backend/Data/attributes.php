<?php
require_once("DBconnect.php");

class Attributes extends Database{

        private $conn;
        public function __construct(){

            $this->conn=$this->connect();

        }
       public function Hot($atr_name,$atr_type,$atr_Dv,$atr_value,$pro_id){
        $stmt = $this->conn->prepare("INSERT INTO hotfix(name, type, display_value, valuex, product_id) VALUES (?, ?, ?,? ,? )");
        $stmt->bind_param("sssss",$atr_name,$atr_type,$atr_Dv,$atr_value,$pro_id);
        $stmt->execute();
        $stmt->close();
       }


    
}