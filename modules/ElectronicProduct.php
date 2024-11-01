<?php

// Electronics Product subclass
class ElectronicsProduct extends Product {
    private $warranty;

    public function __construct($id, $name, $brand, $description, $price, $inStock, $warranty) {
        parent::__construct($id, $name, $brand, $description, $price, $inStock);
        $this->warranty = $warranty;
    }

    public function getProductDetails() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'brand' => $this->brand,
            'description' => $this->description,
            'price' => $this->price,
            'inStock' => $this->inStock,
            'attribute' => $this->warranty
        ];
    }
}