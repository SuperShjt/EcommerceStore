<?php


require_once "../Data/DBconnect.php";

// Abstract Product class
abstract class Product {
    protected $id;
    protected $name;
    protected $brand;
    protected $description;
    protected $price;
    protected $inStock;
    protected $db;


    public function __construct($id, $name, $brand, $description, $price, $inStock,$db) {
        $this->id = $id;
        $this->name = $name;
        $this->brand = $brand;
        $this->description = $description;
        $this->price = $price;
        $this->inStock = $inStock;
        $this->db = $db;
    }

    // Common method to fetch product details
    abstract public function getProductDetails();

    // Additional common functionality
    public function getId() {
        return $this->id;
    }
    protected function getImages(){
        $query = "SELECT img_url FROM product_gallery WHERE product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s",$this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return array_column($result->fetch_all(MYSQLI_ASSOC), 'img_url');

    }
    protected function getAttributes(){
        $query = "SELECT display_value, valuex FROM hotfix WHERE product_id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s",$this->id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

}
