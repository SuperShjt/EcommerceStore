<?php

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;
require_once 'Data/DBconnect.php';

// Initialize Database Connection
$dbx = new Database();
$db = $dbx->connect();

/**
 * Attribute Type
 * Defines the structure for product attributes
 */
$attributeType = new ObjectType([
    'name' => 'Attribute',
    'fields' => [
        'display_value' => Type::string(),
        'valuex' => Type::string()
    ]
]);

/**
 * Product Type
 * Defines structure for individual products with resolvers for fields that require database queries
 */
$produtcType = new ObjectType([
    'name' => 'Product',
    'fields' => [
        'id' => Type::string(),
        'name' => Type::string(),
        'brand' => Type::string(),
        'description' => Type::string(),
        'inStock' => Type::boolean(),
        'price' => [
            'type' => Type::float(),
            'resolve' => function($root) use($db) {
                $product_id = $root['id'];
                $query = 'SELECT amount FROM prices WHERE product_id = ?';
                $stmt = $db->prepare($query);
                $stmt->bind_param('s', $product_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $price = $result->fetch_assoc();
                return $price['amount'];
            }
        ],
        'img_url' => [
            'type' => Type::string(),
            'resolve' => function($root) use($db) {
                $product_id = $root['id'];
                $query = 'SELECT img_url FROM product_gallery WHERE product_id = ?';
                $stmt = $db->prepare($query);
                $stmt->bind_param("s", $product_id);
                $stmt->execute();
                $result = $stmt->get_result();
                $img = $result->fetch_assoc();
                return $img['img_url'];
            }
        ],
        'attributes' => [
            'type' => Type::listOf($attributeType),
            'resolve' => function($root) use($db) {
                $product_id = $root['id'];
                $query = 'SELECT display_value, valuex FROM hotfix WHERE product_id = ?';
                $stmt = $db->prepare($query);
                $stmt->bind_param("s", $product_id);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result->fetch_all(MYSQLI_ASSOC);
            }
        ]
    ]
]);

/**
 * Query Type
 * Defines the root query for fetching multiple products
 */
$QueryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'products' => [
            'type' => Type::listOf($produtcType),
            'resolve' => function() use($db) {
                $query = 'SELECT * FROM products';
                $result = $db->query($query);
                if (!$result) {
                    echo "Database query failed";
                    var_dump($db->error);
                    return null;
                }
                $products = $result->fetch_all(MYSQLI_ASSOC);

                // Map each product's basic fields, letting `Product` type resolvers handle `price`, `img_url`, and `attributes`
                return array_map(function($product) {
                    return [
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'brand' => $product['brand'],
                        'description' => $product['Des'],
                        'inStock' => $product['inStock']
                    ];
                }, $products);
            }
        ]
    ]
]);

// Create Schema
$schema = new Schema([
    'query' => $QueryType
]);

?>
