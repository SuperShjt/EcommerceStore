<?php
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;

require_once '../Data/DBconnect.php';
require_once '../Modules/ClothProduct.php';
require_once '../Modules/ElectronicProduct.php';

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
        'id' => Type::string(),
        'name' => Type::string(),
        'brand' => Type::string(),
        'description' => Type::string(),
        'inStock' => Type::boolean(),
        'category' => Type::string(),
        'price' => Type::float(),
        'img_url' => Type::listOf(Type::string()),
        'attributes' => Type::listOf($attributeType)
    ],
    'resolveField' => function($product, $args, $context, $info) {
        file_put_contents('debug.log', "Resolving field: " . $info->fieldName . " for product ID: " . $product['id'], FILE_APPEND);
        return $product[$info->fieldName];
    }
]);

$QueryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'products' => [
            'type' => Type::listOf($productType),
            'resolve' => function() use($db) {
                try {
                    $result = $db->query("SELECT * FROM products");
                    $products = $result->fetch_all(MYSQLI_ASSOC);
                    return array_map(function($productData) use ($db) {
                        file_put_contents('debug.log', "Mapping product: " . print_r($productData, true), FILE_APPEND);
                        $category_id = $productData['category_id']; 
                        return $category_id === 2
                        ? new ClothProduct($productData, $db)
                        : new TechProduct($productData, $db);


                    }, $products);
                } catch (Exception $e) {
                    error_log('Error fetching products: ' . $e->getMessage());
                    
                    return null; // Return null to indicate an error
                }
            }
        ]
    ]
]);


$schema = new Schema([
    'query' => $QueryType
]);
?>
