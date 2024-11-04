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
        $this->category = $this->fetchCategory($db);
        $this->price = $this->fetchPrice($db);
        $this->img_urls = $this->fetchImages($db);
        $this->attributes = $this->fetchAttributes($db);
        
        
    }

    protected function fetchCategory($db) {
        $stmt = $db->prepare("SELECT c.Cat_name FROM categories c JOIN products p ON c.id = p.category_id WHERE p.id = ?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['Cat_name'] ?? null;
    }

    protected function fetchPrice($db) {
        $stmt = $db->prepare("SELECT amount FROM prices WHERE product_id = ?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
       
        return $result['amount'] ?? 0;
    }

    protected function fetchImages($db) {
        $stmt = $db->prepare("SELECT img_url FROM product_gallery WHERE product_id = ?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        $images = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return array_column($images, 'img_url');
    }

    protected function fetchAttributes($db) {
        $stmt = $db->prepare("SELECT display_value, valuex FROM hotfix WHERE product_id = ?");
        $stmt->bind_param("s", $this->id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

