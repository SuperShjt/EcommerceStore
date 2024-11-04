<?php
require_once 'Product.php';
class ClothProduct extends Product {
    public function __construct($productData, $db) {
        parent::__construct($productData, $db);
    }

    public function getProductDetails() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'brand' => $this->brand,
            'description' => $this->description,
            'price' => $this->price,
            'inStock' => $this->inStock,
            'category' => $this->category,
            'attributes' => $this->attributes,
            'img_url' => $this->img_urls
        ];
    }
}




?>