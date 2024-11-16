<?php
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;

require_once '../Data/DBconnect.php';
require_once '../Modules/ClothProduct.php';
require_once '../Modules/TechProduct.php';

$dbx = new Database();
$db = $dbx->connect();

$attributeType = new ObjectType([
    'name' => 'Attribute',
    'fields' => [
        'display_value' => Type::string(),
        'valuex' => Type::string()
    ]
]);

$productType = new ObjectType([
    'name' => 'product',
    'fields' => [
        'id' => [
            'type' => Type::string(),
            'resolve' => function($root) {
                return $root->getId(); // Call the getter method for id
            }
        ],
        'name' => [
            'type' => Type::string(),
            'resolve' => function($root) {
                return $root->getName(); // Call the getter method for name
            }
        ],
     /*    'brand' => [
            'type' => Type::string(),
            'resolve' => function($root) {
                return $root->getBrand(); // Call the getter method for brand
            }
        ], */
       /*  'description' => [
            'type' => Type::string(),
            'resolve' => function($root) {
                return $root->getDescription(); // Call the getter method for description
            }
        ], */
      /*   'inStock' => [
            'type' => Type::boolean(),
            'resolve' => function($root) {
                return $root->getStock(); // Call the getter method for inStock
            }
        ], */
   /*      'category' => [
            'type'=>Type::string(),
            'resolve'=> function($root){
                return $root->getCategory();
            }
        ], */
        'price' => [
            'type'=>Type::float(),
            'resolve'=> function($root){
                return $root->getprice();
            }
        ],
        'img_url' => [
           'type'=>Type::listOf(Type::string()),
           'resolve'=> function($root){
                return $root->getImages();
           }
        ]
       /*  'attributes' => [
            'type'=>Type::listOf($attributeType) ,
            'resolve'=> function($root){
                return $root->getAttribute();
            }
            
        ] */
    ]
]);

$QueryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'products' => [
            'type' => Type::listOf($productType),
            'args' => [
                'type' => Type::string() // Accepts "cloth" or "tech"
            ],
            'resolve' => function($root, $args) use($db) {
                $typeFilter = $args['type'] ?? null;
                $query = "SELECT * FROM products";

                if ($typeFilter === 'cloth') {
                    $query .= " WHERE category_id = 2";
                } elseif ($typeFilter === 'tech') {
                    $query .= " WHERE category_id = 3";
                }

                $result = $db->query($query);
                $products = $result->fetch_all(MYSQLI_ASSOC);

                return array_map(function($productData) use ($db) {
                    $category_id = $productData['category_id']; 

                    if ($category_id == 2) {
                        return new ClothProduct($productData, $db);
                    } elseif ($category_id == 3) {
                        return new TechProduct($productData, $db);
                    }
                }, $products);
            }
        ]
    ]
]);


$schema = new Schema([
    'query' => $QueryType
]);
?>
