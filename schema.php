<?php

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;
require_once 'Data/DBconnect.php';

$dbx = new Database();
$db = $dbx->connect();
/**
 * Product Type
 */
$protducType = new ObjectType([
    'name' => 'Product',
    'fields' => [
        'id' => Type::string(),
        'name' => Type::string(),
        'brand' => Type::string(),
        'description' => Type::string(),
        'inStock' => Type::boolean(),
         'price' => [
            'type' => Type::float(),
            'resolve' => function($root) use($db){
                $product_id=$root['id'];
                $query = 'SELECT amount FROM prices WHERE product_id = ?';
                $stmt = $db->prepare($query);
                $stmt->bind_param('s',$product_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $price = $result->fetch_assoc();
                return $price['amount'];
            }
        ], 
        'img_url' =>[
            'type' => Type::string(),
            'resolve' => function($root) use($db){
                $product_id = $root['id'];
                $query = 'SELECT img_url FROM product_gallery WHERE product_id = ?';
                $stmt = $db->prepare($query);
                $stmt->bind_param("s",$product_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $img = $result->fetch_assoc();
                return $img['img_url'];
            }
        ],
        'attributes' => [
            'type' => Type::listOf($attributeType),
            'resolve' => function($root) use($db){
                $product_id = $root['id'];
                $query = 'SELECT display_value, valuex FROM hotfix WHERE product_id = ? ';
                $stmt = $db->prepare($query);
                $stmt->bind_param("s",$product_id);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        ]
    ]
]);

$attributeType = new ObjectType([
    'name' => 'Attribute',
    'fields' => [
        'display_value' => Type::sting(),
        'valuex' => Type::string()
    ]
]);

$QueryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'products' => [
            'type' => Type::listOf($protducType),
            'resolve' => function() use($db){
                $query = 'SELECT p.*,pr.amount FROM products p JOIN prices pr ON p.id = pr.product_id';
                $result = $db->query($query);
                if(!$result){
                    echo "i failed"."<br>";
                    var_dump($db->error);
                }
                 //print_r($result->fetch_all());
                 $products = $result->fetch_all(MYSQLI_ASSOC);
                 return array_map(function($product) {
                     // Return individual fields, including description
                     return [
                         'id' => $product['id'],
                         'name' => $product['name'],
                         'brand' => $product['brand'],
                         'description' => $product['Des'], // Ensure this field has data in the DB
                         'inStock' => $product['inStock'],
                         'price' => $product['amount'] //  this is from the `prices` table
                     ];
                 }, $products);
            }
        ]
    ]

]);

$schema = new Schema([
    'query' => $QueryType
]);

 

?>