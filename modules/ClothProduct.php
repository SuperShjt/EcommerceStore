<?php

class ClothingProduct extends Product {
    private $size;

    public function __construct($id, $name, $brand, $description, $price, $inStock, $size) {
        parent::__construct($id, $name, $brand, $description, $price, $inStock);
        $this->size = $size;
    }

    public function getProductDetails() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'brand' => $this->brand,
            'description' => $this->description,
            'price' => $this->price,
            'inStock' => $this->inStock,
            'size' => $this->size
        ];
    }
}




?>