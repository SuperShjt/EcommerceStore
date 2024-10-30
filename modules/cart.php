<?php
function addcart($productid){
    $quantity = 1;
    /**
     * if there is product in cart it add on it
     */
    if(isset($_SESSION['cart'][$productid])){
        $_SESSION['cart'][$productid] += $quantity ;

    }else{
        $_SESSION['cart'][$productId] = $quantity;
    }


}
function removecart($productId){ 
    if (isset($_SESSION['cart'][$productId])) {
    unset($_SESSION['cart'][$productId]);
}}
function getcart(){
    foreach ($_SESSION['cart'] as $productId => $quantity) {
        echo "Product ID: $productId, Quantity: $quantity <br>";
    }
}

?>