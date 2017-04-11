<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$data = json_encode(file_get_contents("php://input"));

print_r($data);
die("here");

$product->id = $data->id;

if($product->deleteProduct()){

	echo '{';
		echo '"message" : "Product was deleted"';
	echo '}';
}else{
	echo '{';
		echo '"message" : "Product unable to delete"';
	echo '}';
}
?>