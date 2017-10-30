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
 
// prepare product object
$product = new Product($db);
 
// get product id
$data = json_decode(file_get_contents("php://input"));
 
// set product id to be deleted
$product->id = $data->id;
 
// delete the product
if($product->delete()){
    echo '{';
        echo '"message": "Product was deleted."';
    echo '}';
}
 
// if unable to delete the product
else{
    echo '{';
        echo '"message": "Unable to delete object."';
    echo '}';
}
?>