<?php

require_once("DBconnect.php");

class Orders extends Database{
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function createOrder($product_id, $price, $attributes) {
        
        

        if (is_string($attributes)) {
            
            $attributesDecoded = json_decode($attributes, true);
    
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log("JSON Decode Error: " . json_last_error_msg());
                return false; 
            }
    
        } else {
            // If already an array, use it as is
            $attributesDecoded = $attributes;
            
        }
    
        // Convert attributes back to JSON to store in database
        $attributes_json = json_encode($attributesDecoded);
    
        
    
        
        $stmt = $this->db->prepare("INSERT INTO orders (product_id, price, attributes) VALUES (?, ?, ?)");
        
        
        $stmt->bind_param("sds", $product_id, $price, $attributes_json);
    
        // Execute the statement and check for errors
        if ($stmt->execute()) {
            return true;  // Successfully inserted
        } else {
            
            error_log("Error executing query: " . $stmt->error);
            return false; // Failed to insert
        }
    }
    
    
}

?>