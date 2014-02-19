<?php

session_start();
date_default_timezone_set('America/New_York');

require('ormItem.php');
require('ormOrder.php');

$path_components = explode('/', $_SERVER['PATH_INFO']);


if ($_SERVER['REQUEST_METHOD'] == "POST") {
	 if ((count($path_components) >= 2) &&
      ($path_components[1] != "")){
       //Liuliu's part
	 }else{
	 	
           $cart_item=$_REQUEST['cart_item'];
	 	
	 	$shipping_address = trim($_REQUEST['shipping_address']);
	    $billing_address = trim($_REQUEST['billing_address']);
	    $email = trim($_REQUEST['email']);
	    $zipcode = trim($_REQUEST['zipcode']);
	    $total_price = trim($_REQUEST['totalPrice']);
	    $order_time = date('m/d/Y h:i:s a', time());
	     
	    
	    
        

	    $new_order = Order::create($order_time, $shipping_address, $billing_address, $email, $zipcode, $total_price);
	    

	    if ($new_order == null){
	    	
		    header("HTTP/1.0 400 Bad Request");
		    print("Server couldn't create new order in ORDER table");
		    exit();
	    }
	    
 
	    $order_id = $new_order->getOrderID();
        
        //insert into order_item table
	    
	    foreach($cart_item as $singleitem) {
		    $item_id = $singleitem["id"];
		    $quantity = $singleitem["quantity"];
		    $new_order_item = OrderItem::create($order_id, $item_id, $quantity);
		    
		    if($new_order_item==null){
			    header("HTTP/1.0 500 Server Error");
			    print("Server couldn't create new order item in order_item table");
			    exit();
		    } 
		   

		    $updateInventory = Item::updateQuantityByID($item_id, $quantity);
		    $_SESSION["test112"]=$updateInventory;
		    if($updateInventory==false){
		 	    header("HTTP/1.0 500 Server Error");
			    print("Server couldn't update Inventory table");
			    exit();
		    }
	    }
	    session_destroy();
	    header("Content-type: application/json");
	    print(json_encode(true));
	    exit();
	    



	 }


}else if ($_SERVER['REQUEST_METHOD']=="GET"){
	
	if ((count($path_components) >= 2) &&
      ($path_components[1] != "")) {

    $o_id = intval($path_components[1]);

    $order = Order::findByID($o_id);

    if ($order == null) {
      header("HTTP/1.0 404 Not Found");
      print("Order id: " . $o_id . " not found.");
      exit();
    }

    

    // Normal lookup.
    // Generate JSON encoding as response
    header("Content-type: application/json");
    print($order->getJSON());
    exit();

  } 

  // ID not specified, then must be asking for index
  header("Content-type: application/json");
  print(json_encode(Order::getAllIDs()));
  exit();

     
}
