<?php

define("DB_HOST", "classroom.cs.unc.edu"); 
define("DB_USER", "fanl"); 
define("DB_PASSWORD", "liuliushumeng"); // comp426
define("DB_DB", "fanldb"); //kmpdb

date_default_timezone_set('America/New_York');

class Order
{
  private $order_id;
  private $customer_id;
  private $order_time;
  private $shipping_address;
  private $billing_address;
  private $email;
  private $zipcode;
  private $total_price;

  public static function create($customer_id, $order_time, $shipping_address, $billing_address, $email, $zipcode, $total_price) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);

    $result = $mysqli->query("insert into `ORDER` values (0, " .
			     "'" . $mysqli->real_escape_string($customer_id) . "', " .
			     "'" . $mysqli->real_escape_string($order_time) . "', " .
			     "'" . $mysqli->real_escape_string($shipping_address) . "', " .
			     "'" . $mysqli->real_escape_string($billing_address) . "', " .
			     "'" . $mysqli->real_escape_string($email) . "', " .
			     "'" . $mysqli->real_escape_string($zipcode) . "', " .
			     "'" . $mysqli->real_escape_string($total_price) . ")");
    
    if ($result) {
      $order_id = $mysqli->insert_id;
      return new Order($order_id, $customer_id, $order_time, $shipping_address, $billing_address, $email, $zipcode, $total_price);
    }
    return null;
  }

  public static function findByID($order_id) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);

    $result = $mysqli->query("select * from `ORDER` where `order_id` = " . $order_id);
    if ($result) {
      if ($result->num_rows == 0) {
	return null;
      }

      $order_info = $result->fetch_array();

      return new Order(intval($order_info['order_id']),
          $order_info['customer_id'],
          $order_info['order_time'],
          $order_info['shipping_address'],
          $order_info['billing_address'],
          $order_info['email'],
          $order_info['zipcode'],
          $order_info['total_price']);
    }
    return null;
  }

  public static function getAllIDs() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);

    $result = $mysqli->query("select `order_id` from `ORDER`");
    $id_array = array();

    if ($result) {
      while ($next_row = $result->fetch_array()) {
	$id_array[] = intval($next_row['order_id']);
      }
    }
    return $id_array;
  }  

    private function __construct($order_id, $customer_id, $order_time, $shipping_address, $billing_address, $email, $zipcode, $total_price) {
        $this->order_id = $order_id;
        $this->customer_id = $customer_id;
        $this->order_time = $order_time;
        $this->shipping_address = $shipping_address;
        $this->billing_address = $billing_address;
        $this->email = $email;
        $this->zipcode = $zipcode;
        $this->total_price = $total_price;
    }
  
  public function getCustomerID() {
    return $this->customer_id;
  }

  public function getOrderTime() {
    return $this->order_time;
  }

  public function getShippingAddress() {
    return $this->shipping_address;
  }

  public function getBillingAddress() {
    return $this->billing_address;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getZipcode() {
    return $this->zipcode;
  }

  public function getTotalPrice() {
    return $this->total_price;
  }

  public function setCustomerID($customer_id) {
    $this->customer_id = $customer_id;
    return $this->update();
  }

  public function setOrderTime($order_time) {
    $this->order_time = $order_time;
    return $this->update();
  }

  public function setShippingAddress($shipping_address) {
    $this->shipping_address = $shipping_address;
    return $this->update();
  }

  public function setBillingAddress($billing_address) {
    $this->billing_address = $billing_address;
    return $this->update();
  }

  public function setEmail($email) {
    $this->email = $email;
    return $this->update();
  }

  public function setZipcode($zipcode) {
    $this->zipcode = $zipcode;
    return $this->update();
  }

  public function setTotalPrice($total_price) {
    $this->total_price = $total_price;
    return $this->update();
  }

  private function update() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);

    $result = $mysqli->query("update `ORDER` set " .
			     "customer_id=" .
			     "'" . $mysqli->real_escape_string($this->customer_id) . "', " .
			     "order_time=" .
			     "'" . $mysqli->real_escape_string($this->order_time) . "', " .
			     "shipping_address=" .
			     "'" . $mysqli->real_escape_string($this->shipping_address) . "', " .
                "billing_address=" .
                "'" . $mysqli->real_escape_string($this->billing_address) . "', " .
                "email=" .
                "'" . $mysqli->real_escape_string($this->email) . "', " .
                "zipcode=" .
                "'" . $mysqli->real_escape_string($this->zipcode) . "', " .
                "total_price=" .
                "'" . $mysqli->real_escape_string($this->total_price) . "' " .
			     " where `order_id` =" . $this->order_id);

    return $result;
  }

  public function delete() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
    $mysqli->query("delete from `ORDER` where `order_id` = " . $this->order_id);
  }

  public function getJSON() {

    $json_obj = array('order_id' => $this->order_id,
		      'customer_id' => $this->customer_id,
		      'order_time' => $this->order_time,
		      'shipping_address' => $this->shipping_address,
		      'billing_address' => $this->billing_address,
		      'email' => $this->email,
		      'zipcode' => $this->zipcode,
		      'total_price' => $this->total_price);
    return json_encode($json_obj);
  }
}

class Order_item {
    private $order_id;
	private $item_id;
	private $quantity;
	
 	private function __construct($order_id, $item_id, $quantity, $price) {
	    $this->order_id = $order_id;
	    $this->item_id = $item_id;
        $this->quantity = $quantity;
	}

 
/*-----------------------Find By Order IDs---------------------*/  
  public static function findByOrderID($order_id) {
  
  $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
  
  $result = $mysqli->query("select * from `ORDER_ITEM` where order_id = " . $order_id);
  $id_array = array();

		if ($result){
			while ($next_row = $result -> fetch_array()){
                $id_array[] = array( "item_id" => intval($next_row['item_id']), "quantity" => $next_row['quantity']);
			}
		}
		return $id_array;
	}


}