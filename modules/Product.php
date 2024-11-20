<?php

abstract class Product {
    protected $id;
    protected $name;
    protected $brand;
    protected $description;
    protected $inStock;
    protected $category;
    protected $price;
    protected $img_urls;
    protected $attributes;
    protected $db;

    public function __construct($productData, $db) {
        $this->db = $db;
        $this->id = $productData['id'];
        $this->name = $productData['name'];
        $this->brand = $productData['brand'];
        $this->description = $productData['Des'];
        $this->inStock = $productData['inStock'];        
    }

    protected function fetchCategory() {
        $stmt = $this->db->prepare("SELECT c.Cat_name FROM categories c JOIN products p ON c.id = p.category_id WHERE p.id = ?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['Cat_name'] ?? null;
    }

    protected function fetchPrice() {
        $stmt = $this->db->prepare("SELECT amount FROM prices WHERE product_id = ?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
       
        return $result['amount'] ?? 0;
    }

    protected function fetchImages() {
        $stmt = $this->db->prepare("SELECT img_url FROM product_gallery WHERE product_id = ?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return array_column($images, 'img_url');
    }

    protected function fetchAttributes() {
        $stmt = $this->db->prepare("SELECT DISTINCT  name FROM hotfix WHERE product_id = ?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    protected function fetchID(){
        return $this->id;
    }
    protected function fetchName(){
        return $this->name;
    }
    protected function fetchBrand(){
        return $this->brand;
    }
    protected function fetchStock(){
        return $this->inStock;
    }
    protected function fetchDescription(){
        return $this->description;
    }
    protected function getAttrValue() {
        $query = "SELECT display_value, valuex, name FROM hotfix WHERE product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s', $this->id);
        $stmt->execute();
        $attributes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
        // Group attributes by their 'name'
        $groupedAttributes = [];
        foreach ($attributes as $attribute) {
            $groupedAttributes[$attribute['name']][] = [
                'valuex' => $attribute['valuex'],
                'displayValue' => $attribute['display_value'],
            ];
        }
    
        // Debug: Log the result
        echo (print_r($groupedAttributes, true));
    
        return $groupedAttributes;
    }
    

}

