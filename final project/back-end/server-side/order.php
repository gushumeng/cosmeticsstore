<?php

require_once('orm/Order.php');

$path_components = explode('/', $_SERVER['PATH_INFO']);

// Note that since extra path info starts with '/'
// First element of path_components is always defined and always empty.

if ($_SERVER['REQUEST_METHOD'] == "GET") {


  if ((count($path_components) >= 2) &&
      ($path_components[1] != "")) {

    $o_id = intval($path_components[1]);

    $order = Order::findByID($o_id);

    if ($order == null) {
      header("HTTP/1.0 404 Not Found");
      print("Order id: " . $o_id . " not found.");
      exit();
    }

    if (isset($_REQUEST['delete'])) {
      $order->delete();
      header("Content-type: application/json");
      print(json_encode(true));
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

} else if ($_SERVER['REQUEST_METHOD'] == "POST") {

  // Either creating or updating

  // Following matches /todo.php/<id> form
  if ((count($path_components) >= 2) &&
      ($path_components[1] != "")) {

    //Interpret <id> as integer and look up via ORM
    $o_id = intval($path_components[1]);
    $order = Order::findByID($o_id);

    if ($order == null) {
      // Todo not found.
      header("HTTP/1.0 404 Not Found");
      print("Order id: " . $o_id . " not found while attempting update.");
      exit();
    }

    // Validate values
    $new_customer_id = false;
    if (isset($_REQUEST['customer_id'])) {
      $new_customer_id = trim($_REQUEST['customer_id']);
    }

    $new_order_time = false;
    if (isset($_REQUEST['order_time'])) {
      $new_order_time = trim($_REQUEST['order_time']);
    }

    $new_shipping_address = false;
    if (isset($_REQUEST['shipping_address'])) {
      $new_shipping_address = trim($_REQUEST['shipping_address']);
    }

    $new_billing_address = false;
    if (isset($_REQUEST['billing_address'])) {
      $new_billing_address = trim($_REQUEST['billing_address']);
    }
	
	$new_email = false;
    if (isset($_REQUEST['email'])) {
      $new_email = trim($_REQUEST['email']);
    }

    $new_zipcode = false;
    if (isset($_REQUEST['zipcode'])) {
      $new_zipcode = trim($_REQUEST['zipcode']);
    }

    $new_total_price = false;
    if (isset($_REQUEST['total_price'])) {
      $new_total_price = trim($_REQUEST['total_price']);
    }

    // Update via ORM
    if ($new_customer_id) {
      $order->setCustomerID($new_customer_id);
    }
    if ($new_order_time != false) {
      $order->setOrderTime($new_order_time);
    }
    if ($new_shipping_address != false) {
      $order->setShippingAddress($new_shipping_address);
    }
    if ($new_billing_address != false) {
      $order->setBillingAddress($new_billing_address);
    }
    if ($new_email != false) {
      $order->setEmail($new_email);
    }
	if ($new_zipcode != false) {
      $order->setZipcode($new_zipcode);
    }
    
	if ($new_total_price != false) {
      $order->setTotalPrice($new_total_price);
    }

    // Return JSON encoding of updated Todo
    header("Content-type: application/json");
    print($order->getJSON());
    exit();
  } else {

    // Creating a new Todo item

    // Validate values
    $customer_id = "";
    if (isset($_REQUEST['customer_id'])) {
      $customer_id = trim($_REQUEST['customer_id']);
    }

    $order_time = "";
    if (isset($_REQUEST['order_time'])) {
      $order_time = trim($_REQUEST['order_time']);
    }

    $shipping_address = "";
    if (isset($_REQUEST['shipping_address'])) {
      $shipping_address = trim($_REQUEST['shipping_address']);
    }

    $billing_address = "";
    if (isset($_REQUEST['billing_address'])) {
      $billing_address = trim($_REQUEST['billing_address']);
    }

    $email = "";
    if (isset($_REQUEST['email'])) {
      $email = trim($_REQUEST['email']);
    }
	
    $zipcode = "";
    if (isset($_REQUEST['zipcode'])) {
      $zipcode = trim($_REQUEST['zipcode']);
    }	
	
    $total_price = "";
    if (isset($_REQUEST['total_price'])) {
      $total_price = trim($_REQUEST['total_price']);
    }		

    // Create new Todo via ORM
    $new_order = Order::create($customer_id, $order_time, $shipping_address, $billing_address, $email, $zipcode, $total_price);

    // Report if failed
    if ($new_order == null) {
      header("HTTP/1.0 500 Server Error");
      print("Server couldn't create new todo.");
      exit();
    }
    
    //Generate JSON encoding of new Todo
    header("Content-type: application/json");
    print($new_order->getJSON());
    exit();
  }
}

// If here, none of the above applied and URL could
// not be interpreted with respect to RESTful conventions.

header("HTTP/1.0 400 Bad Request");
print("Did not understand URL");

?>