<?php
session_start();


// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

require 'vendor/autoload.php';
require 'schema.php';
require 'cart.php';

use GraphQL\GraphQL;

try {
    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);
    $query = $input['query'];

    // Process the GraphQL query
    $result = GraphQL::executeQuery($schema, $query);
    $output = $result->toArray();
    header('Content-Type: application/json');
    echo json_encode($output);
} catch (\Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}




?>