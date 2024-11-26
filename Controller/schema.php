<?php
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;

require_once '../Data/DBconnect.php';
require_once '../Modules/ClothProduct.php';
require_once '../Modules/TechProduct.php';
require_once '../Data/Orders.php'; 

$dbx = new Database();
$db = $dbx->connect();

$Orders = new Orders($db);

$insideAttr = new ObjectType([
    'name' => 'AttributeItem',
    'fields' => [
        'valuex' => Type::string(),
        'display_value' => Type::string(),
    ]
]);



$attributeType = new ObjectType([
    'name' => 'Attribute',
    'fields' => [
        'name'=>Type::string(),
        'items'=>[
            'type'=>Type::listOf($insideAttr),
            'resolve' => function($root, $args) use($db){
                $query = "SELECT display_value, valuex FROM hotfix WHERE product_id = ? AND name = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param('ss', $root['id'],$root['name']);
                $stmt->execute();
                $result = $stmt->get_result();
                $out=$result->fetch_all(MYSQLI_ASSOC);

                // Transform values into the expected format
                return array_map(function($out) {
                    return [
                        'valuex' => $out['valuex'],
                        'display_value' => $out['display_value'], // If displayValue is same as value
                    ];
                }, $out);
                

            }
        ]
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
        'inStock'=>[
            'type'=>Type::boolean(),
            'resolve'=> function($root){
                return $root->getStock();
            }
        ]
   
    ]
]);

$FullProduct = new ObjectType([

        'name'=> 'fullproduct',
        'fields'=>[
            'id'=>[
                'type'=>Type::string(),
                'resolve'=>function($root){
                    return $root->getId();
                }
            ],
           'name' => [
            'type' => Type::string(),
            'resolve' => function($root) {
                return $root->getName(); // Call the getter method for name
            }
        ],
         'brand' => [
            'type' => Type::string(),
            'resolve' => function($root) {
                return $root->getBrand(); // Call the getter method for brand
            }
        ], 
        'description' => [
            'type' => Type::string(),
            'resolve' => function($root) {
                return $root->getDescription(); // Call the getter method for description
            }
        ], 
        'inStock' => [
            'type' => Type::boolean(),
            'resolve' => function($root) {
                return $root->getStock(); // Call the getter method for inStock
            }
        ], 
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
                $attributes=$root->getAttribute();
                return array_map(function($attribute) use ($root) {
                    $attribute['id'] = $root->getID(); // Attach the product ID to each attribute
                    return $attribute;
                }, $attributes);

            }
            
        ]

     ]
]);




$mutationType = new ObjectType([
    'name' => 'Mutation',
    'fields' => [
        'createOrder' => [
            'type' => Type::string(), // Return a success message
            'args' => [
                'product_id' => Type::nonNull(Type::string()),
                'price' => Type::nonNull(Type::float()),
                'attributes' => Type::nonNull(Type::string()), // Attributes passed as JSON string
            ],
            'resolve' => function($root, $args) use ($Orders) {
                $product_id = $args['product_id'];
                $price = $args['price'];
                $attributes = json_decode($args['attributes'], true); // Decode JSON string

                // Add the order to the database using your Orders class
                $Orders->createOrder($product_id, $price, $attributes);

                return "Order added successfully!";
            }
        ]
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
        ],
       'fullproduct' => [
             'type' => $FullProduct, // Single product object
             'args' => [
                     'id' => Type::nonNull(Type::string()) // Require the product ID
               ],
            'resolve' => function($root, $args) use ($db) {
            $query = "SELECT * FROM products WHERE id = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param('s', $args['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $productData = $result->fetch_assoc();

            if (!$productData) {
                return null; // Return null if no product is found
            }

                $category_id = $productData['category_id'];
                if ($category_id == 2) {
                         return new ClothProduct($productData, $db);
                } elseif ($category_id == 3) {
                    return new TechProduct($productData, $db);
            }   

                    return null;
            }
        ]

    ]
]);


$schema = new Schema([
    'query' => $QueryType,
    'mutation' => $mutationType,
]);
?>
