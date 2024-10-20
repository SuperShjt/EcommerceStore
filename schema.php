<?php

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Schema;



$protducType = new ObjectType([
    'name' => 'Product',
    'fields' => [
        'id' => Type::notnull(Type::string()),
        'name' => Type::string(),
        'brand' => Type::string(),
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
])




























?>