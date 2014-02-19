<?php

require_once('orm/Order.php');

$path_components = explode('/', $_SERVER['PATH_INFO']);

if ($_SERVER['REQUEST_METHOD'] == "GET") {

  if ((count($path_components) >= 2) &&
      ($path_components[1] != "")) {

    $item_id = intval($path_components[1]);

    $order_item = Order_item::findByOrderID($item_id);

    if ($order_item == null) {
      header("HTTP/1.0 404 Not Found");
      print("Item id: " . $item_id . " not found.");
      exit();
    }
	else {

        header("Content-type: application/json");
        print(json_encode($order_item));
        exit();
    }
  } 
  else {
        header("HTTP/1.0 400 Bad Request");
		print("No order id is specified");
		exit();

  }
}
?>