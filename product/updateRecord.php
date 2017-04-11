<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Content-Type: application/json; charset= UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once "../config/database.php";
include_once "../objects/product.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of product to be edited
$product->id = $data->id;

// set product property values
$product->name = $data->name;
$product->description = $data->description;
$product->price = $data->price;
$product->category_id = $data->category_id;

//update product
if($product->updateProduct()){
	echo '{';
		echo '"message" : "Product Updated"';
	echo '}';
}else{
	echo '{';
		echo '"message":"Unable to update"';
	echo '}';
}
?>