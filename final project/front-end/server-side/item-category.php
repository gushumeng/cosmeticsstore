<?php

require('ormItem.php');

$path_components = explode('/', $_SERVER['PATH_INFO']);

if($_SERVER['REQUEST_METHOD'] == "GET"){
	if((COUNT($path_components) >=2) &&
		($path_components[1] !='')) {
		$category_id = intval($path_components[1]);

		$item_list = Item::findByCategoryID($category_id);
		if ($item_list == null){
			header("HTTP/1.0 404 Not Found");
			print("Category id: " . $category_id . "not found.");
			exit();
		}
		else{
			header("Content-type: application/json");
			print(json_encode($item_list));
			exit();
		}
	}
	else{
		header("HTTP/1.0 400 Bad Request");
		print("No category id is specified");
		exit();
	}
} 
else if ($_SERVER['REQUEST_METHOD'] == "GET"){
	header("HTTP/1.0 400 Bad Request");
	print("Wrong request method");
	exit();
}