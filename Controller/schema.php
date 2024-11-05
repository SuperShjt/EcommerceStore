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
        'id' => Type::string(),
        'name' => Type::string(),
        'brand' => Type::string(),
        'description' => Type::string(),
        'inStock' => Type::boolean(),
        'category' => [
            'type'=>Type::string(),
            'resolve'=> function($root){
                return $root->getCategory();
            }
        ],
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
        ],
        'attributes' => [
            'type'=>Type::listOf($attributeType) ,
            'resolve'=> function($root){
                return $root->getAttribute();
            }
            
        ]
    ]
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
                        if($category_id == 2 || $category_id == '2'){
                            return new ClothProduct($productData,$db);
                        }elseif($category_id == 3 || $category_id == '3'){
                            return new TechProduct($productData,$db);
                        }


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
