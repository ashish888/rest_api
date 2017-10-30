<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../classes/class.database.php';
include_once '../classes/class.product.php';
 
// instantiate database and product object
$database = new DB_Connection($_SERVER['DOCUMENT_ROOT'].'/rest_api/config/CONNECTION.properties');
$db = DB_Connection::connect();
 
$product = new Product($db);
 
// get posted data
$data = $_POST;


// set product property values
$product->name = $data['name'];
$product->price = $data['price'];
$product->description = $data['description'];
$product->category_id = $data['category_id'];
$product->created = date('Y-m-d H:i:s');
 
// create the product
if($product->create()){
    echo '1';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create product."';
    echo '}';
}
?>