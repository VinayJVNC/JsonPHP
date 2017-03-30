<?php
header("Access-Control-Origin: *");
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

/*print_r($product);
exit();*/
$data = json_decode(file_get_contents("php://input"));

// set ID property of product to be edited
$product->id = $data->id;

$product->name = $data->name;
$product->price = $data->price;
$product->description = $data->description;
$product->category_id = $data->category_id;
$product->created = date('Y-m-d H:i:s');

if ($product->create()){
	echo '{';
		echo '"message" : "Product Created."';
	echo '}';
}else{
	echo '{';
		echo '"Message" : "Unable to create product"';
	echo '}';
}
?>