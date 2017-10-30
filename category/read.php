<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../classes/class.database.php';
include_once '../classes/class.category.php';
 
// instantiate database and category object
$database = new DB_Connection($_SERVER['DOCUMENT_ROOT'].'/rest_api/config/CONNECTION.properties');
$db = DB_Connection::connect();

// initialize object
$category = new Category($db);
 
// query categories
$stmt = $category->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
    $categories_arr=array();
    $categories_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $category_item=array(
            "id" => $id,
            "name" => $name,
            "description" => html_entity_decode($description),
            "created" => $created,
            "modified" => $modified
        );
 
        array_push($categories_arr["records"], $category_item);
    }
 
    echo json_encode($categories_arr);
}
 
else{
    echo json_encode(
        array("message" => "No categories found.")
    );
}
?>