<?php

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;
require_once '../Data/DBconnect.php';

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
$productType = new ObjectType([
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
            'type' => Type::listOf(Type::string()), // Adjust the type to listOf strings
             'resolve' => function($root) use($db){
                 $product_id = $root['id'];
                    $query = 'SELECT img_url FROM product_gallery WHERE product_id = ?';
                        $stmt = $db->prepare($query);
                        $stmt->bind_param("s", $product_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                         $images = $result->fetch_all(MYSQLI_ASSOC);

                     return array_column($images, 'img_url');
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
// Define Cart Mutations
$addToCartMutation = [
    'name' => 'addToCart',
    'type' => $productType,
    'args' => [
        'productId' => Type::nonNull(Type::string()),
        'quantity' => Type::int()
    ],
    'resolve' => function($root, $args) {
        $productId = $args['productId'];
        $quantity = $args['quantity'] ?? 1;

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = ['quantity' => $quantity];
        }

        return $_SESSION['cart'][$productId];
    }
];
$updateCartQuantityMutation = [
    'name' => 'updateCartQuantity',
    'type' => $productType,
    'args' => [
        'productId' => Type::nonNull(Type::string()),
        'quantity' => Type::nonNull(Type::int())
    ],
    'resolve' => function($root, $args) {
        $productId = $args['productId'];
        $quantity = $args['quantity'];

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        }

        return $_SESSION['cart'][$productId];
    }
];
$removeFromCartMutation = [
    'name' => 'removeFromCart',
    'type' => Type::boolean(),
    'args' => [
        'productId' => Type::nonNull(Type::string())
    ],
    'resolve' => function($root, $args) {
        $productId = $args['productId'];

        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
            return true;
        }
        return false;
    }
];
$mutationType = new ObjectType([
    'name' => 'Mutation',
    'fields' => [
        'addToCart' => $addToCartMutation,
        'updateCartQuantity' => $updateCartQuantityMutation,
        'removeFromCart' => $removeFromCartMutation
    ]
]);
//==============================================================================================
/**
 * Query Type
 * Defines the root query for fetching multiple products
 */
$QueryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'products' => [
            'type' => Type::listOf($productType),
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
