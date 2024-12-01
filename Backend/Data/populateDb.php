<?php
require_once("DBconnect.php");
require_once("Categories.php");
require_once("Products.php");
require_once("gallery.php");
require_once("attributes.php");
require_once("Prices.php");



$json = file_get_contents('data.json');
$data = json_decode($json, true);

//------------------------------populate Products table---------------------------------------------------------------------------------
$myproduct = new Products();
if(isset($data['data']['products'])){

    foreach ($data['data']['products'] as $pro) {

        $myproduct->insert($pro['id'],$pro['name'],$pro['inStock'],$pro['description'],$pro['category'],$pro['brand']);
        
    }

}

//------------------------------populate categories table---------------------------------------------------------------------------------
$catax = new Cate();
if (isset($data['data']['categories'])) {
 foreach ($data['data']['categories'] as $category) {
     echo "Category Name: " . $category['name'] . "<br>";
     $catax->insert($category['name']);
 }
}

//------------------------------populate attribute table---------------------------------------------------------------------------------

$atrx = new Attributes();
foreach($data['data']['products'] as $pro){
    foreach($pro['attributes'] as $atr){
        foreach($atr['items'] as $it)

        $atrx->Hot($atr['name'],$atr['type'],$it['displayValue'],$it['value'],$pro['id']);

    }
}
//------------------------------populate Gallery table---------------------------------------------------------------------------------

$mygallery =  new Gallery();
if(isset($data['data']['products'])){
    foreach ($data['data']['products'] as  $photo){
        foreach ($photo['gallery'] as $img_url) {
            $mygallery->insert($photo['id'], $img_url); 
        }
    }
}
//------------------------------populate prices table---------------------------------------------------------------------------------
$p = new price();
foreach($data['data']['products'] as $pro){
    foreach($pro['prices'] as $pri)
    {   
            $p->inser($pro['id'],$pri['amount']);
            $p->insert_currency($pro['id'],$pri['currency']['label'],$pri['currency']['symbol']);

    }
    
}










































