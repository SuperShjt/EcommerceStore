<?php
require_once 'Product.php';
class TechProduct extends Product {
    public function __construct($productData, $db) {
        parent::__construct($productData, $db);
    }
    public function getCategory(){
        return $this->fetchCategory();
    }
    public function getPrice(){
        return $this->fetchPrice();
    }
    //fetchImages
    public function getImages(){
        return $this->fetchImages();
    }
    //fetchAttributes
    public function  getAttribute(){
        return $this->fetchAttributes();
    }
    public function getID(){
        return $this->fetchID();
    }
    public function getName(){
        return $this->fetchName();
    }
    public function getBrand(){
        return $this->fetchBrand();
    }
    public function getStock(){
        return $this->fetchStock();
    }
    public function getDescription(){
        return $this->fetchDescription();
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
