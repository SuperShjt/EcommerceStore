<?php

// Abstract Product class
abstract class Product {
    protected $id;
    protected $name;
    protected $brand;
    protected $description;
    protected $price;
    protected $inStock;

    public function __construct($id, $name, $brand, $description, $price, $inStock) {
        $this->id = $id;
        $this->name = $name;
        $this->brand = $brand;
        $this->description = $description;
        $this->price = $price;
        $this->inStock = $inStock;
    }

    // Common method to fetch product details
    abstract public function getProductDetails();

    // Additional common functionality
    public function getId() {
        return $this->id;
    }

   
}
