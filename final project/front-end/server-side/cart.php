<?php
session_start();
require('ormItem.php');

$path_components = explode('/', $_SERVER['PATH_INFO']);

if ($_SERVER['REQUEST_METHOD'] == "POST"){

	if ((count($path_components) >= 2) &&
      ($path_components[1] != "")) {
		//update the number of certain item in a cart 
		$cart_item_id = intval($path_components[1]);
	    foreach($_SESSION['cart'] as &$item){
	    	if($item["id"]==$cart_item_id){
	    		$item["quantity"] = $_REQUEST['quantity'];
	    		header("Content-type: application/json");
	    	    print(json_encode(true));
	    	    exit();
	    	}
	    }
	
	   
	    	header("HTTP/1.0 404 Not Found");
	    	print("item id" . $cart_item_id . "does not exist in the cart");
	    	exit();
	    
	}
	else{
		//create a new cart item
		
			$item_id = trim($_REQUEST['item_id']);
			$item_name = trim($_REQUEST['name']);
			$item_price = trim($_REQUEST['price']);
			$quantity = trim($_REQUEST['quantity']);

			
		
			$new_item_in_cart = array('id' => $item_id,
				                      'name' => $item_name,
				                      'price' => $item_price,
				                      'quantity' => $quantity);

			if (isset($_SESSION["cart"])){
				foreach($_SESSION['cart'] as &$item){
	    	        if($item["id"]==$item_id){	    	    
	    		    $item["quantity"] = $quantity;
	    		    $_SESSION["test"] = $item["quantity"];
	    		    header("Content-type: application/json");
	    	        print(json_encode(true));
	    	        exit();
	    	        }
	    	    }
				$_SESSION["cart"][] = $new_item_in_cart;
				
			}
			else {
				$_SESSION["cart"] = array();
				$_SESSION["cart"][] = $new_item_in_cart;
			}	
			

            
		    header("Content-type: application/json"); 
            print($_REQUEST['quantity']);
		    exit();	
		
	}
	
} else if ($_SERVER['REQUEST_METHOD'] == "GET"){
	//return all item infor in the cart 
	
	header("Content-type: application/json");
	print(json_encode($_SESSION["cart"]));
	exit();
}
