<?php

require_once('orm/Inventory.php');

$path_components = explode('/', $_SERVER['PATH_INFO']);
print($path_componets);
if ($_SERVER['REQUEST_METHOD'] == "GET") {

  if ((count($path_components) >= 2) &&
      ($path_components[1] != "")) {

    $item_id = intval($path_components[1]);

    // Look up object via ORM
    $inventory = Inventory::findByID($item_id);

    if ($inventory == null) {
      // Inventory not found.
      header("HTTP/1.0 404 Not Found");
      print("Inventory id: " . $item_id . " not found.");
      exit();
    }

    // Check to see if deleting
    if (isset($_REQUEST['delete'])) {
      $inventory->delete();
      header("Content-type: application/json");
      print(json_encode(true));
      exit();
    }

    // Normal lookup.
    // Generate JSON encoding as response
    header("Content-type: application/json");
    print($inventory->getJSON());
    exit();

  } else {
      $inventory_ids = Inventory::getAllIDs();

      if( count($inventory_ids) == 0 ) {
          // Inventory not found.
          header("HTTP/1.0 404 Not Found");
          print("Inventory not found.");
          exit();
      }

      header("Content-type: application/json");
      print(json_encode($inventory_ids));
      exit();
  }

  // ID not specified, then must be asking for index
  header("Content-type: application/json");
  print(json_encode(Inventory::getAllIDs()));
  exit();

} else if ($_SERVER['REQUEST_METHOD'] == "POST") {

  // Either creating or updating

  // Following matches /inventory.php/<id> form
  if ((count($path_components) >= 2) &&
      ($path_components[1] != "")) {

    //Interpret <id> as integer and look up via ORM
    $inventory_id = intval($path_components[1]);
    $inventory = Inventory::findByID($inventory_id);

    if ($inventory == null) {
      // Inventory not found.
      header("HTTP/1.0 404 Not Found");
      print("Inventory id: " . $inventory_id . " not found while attempting update.");
      exit();
    }

    // Validate values
    $new_name = false;
    if (isset($_REQUEST['item_name'])) {
      $new_name = trim($_REQUEST['item_name']);
      if ($new_name == "") {
	header("HTTP/1.0 400 Bad Request");
	print("Bad item name");
	exit();
      }
    }

    $new_category = false;
    if (isset($_REQUEST['category'])) {
      $new_category = trim($_REQUEST['category']);
      if ($new_category == "") {
	header("HTTP/1.0 400 Bad Request");
	print("Bad category");
	exit();
      }
    }	
	
    $new_price = false;
    if (isset($_REQUEST['price'])) {
      $new_price = trim($_REQUEST['price']);
      if ($new_price == "") {
	header("HTTP/1.0 400 Bad Request");
	print("Bad price");
	exit();
      }
    }

    $new_stock = false;
    if (isset($_REQUEST['stock'])) {
      $new_stock = trim($_REQUEST['stock']);
      if ($new_stock == "") {
	header("HTTP/1.0 400 Bad Request");
	print("Bad stock");
	exit();
      }
    }

     $new_description = false;
    if (isset($_REQUEST['description'])) {
      $new_description = trim($_REQUEST['description']);
    }
	
	 $new_image = false;
    if (isset($_REQUEST['image'])) {
      $new_image = trim($_REQUEST['image']);
    }


    // Update via ORM
    if ($new_name) {
      $inventory->setItemName($new_name);
    }
	
    if ($new_category) {
      $inventory->setCategory($new_category);
    }	
	
    if ($new_price != false) {
      $inventory->setPrice($new_price);
    }
    if ($new_stock != false) {
      $inventory->setStock($new_stock);
    }
    if ($new_description != false) {
      $inventory->setDescription($new_description);
    }
    if ($new_image != false) {
      $inventory->setImage($new_image);
    }

    // Return JSON encoding of updated Inventory
    header("Content-type: application/json");
    print($inventory->getJSON());
    exit();
  } else {

    // Creating a new Inventory item

    // Validate values
    if (!isset($_REQUEST['item_name'])) {
      header("HTTP/1.0 400 Bad Request");
      print("Missing item name");
      exit();
    }
    
    $item_name = trim($_REQUEST['item_name']);
    if ($item_name == "") {
      header("HTTP/1.0 400 Bad Request");
      print("Bad item name");
      exit();
    }

    $category = "";
    if (isset($_REQUEST['category'])) {
      $category = trim($_REQUEST['category']);
    }	
	
    $price = "";
    if (isset($_REQUEST['price'])) {
      $price = trim($_REQUEST['price']);
    }

    $stock = "";
    if (isset($_REQUEST['stock'])) {
      $stock = trim($_REQUEST['stock']);
    }

    $description = "";
    if (isset($_REQUEST['description'])) {
      $description = trim($_REQUEST['description']);
    }

    $image = "";
    if (isset($_REQUEST['image'])) {
      $image = trim($_REQUEST['image']);
    }


    // Create new Inventory via ORM
    $new_inventory = Inventory::create($item_name, $category, $price, $stock, $description, $image);

    // Report if failed
    if ($new_inventory == null) {
      header("HTTP/1.0 500 Server Error");
      print("Server couldn't create new inventory.");
      exit();
    }
    
    //Generate JSON encoding of new Inventory
    header("Content-type: application/json");
    print($new_inventory->getJSON());
    exit();
  }
}

// If here, none of the above applied and URL could
// not be interpreted with respect to RESTful conventions.

header("HTTP/1.0 400 Bad Request");
print("Did not understand URL");

?>