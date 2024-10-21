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
        ]
    ]
  ]);
$QueryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'products' => [
            'type' => Type::listOf($protducType),
            'resolve' => function() use($db){
                $query = 'SELECT * FROM products';
                $result = $db->query($query);
                if(!$result){
                    var_dump($db->error);
                }
                print_r($result->fetch_all());
                return $result->fetch_all();
            }
        ]
    ]

        ]);

$schema = new Schema([
    'query' => $QueryType
]);


























?>