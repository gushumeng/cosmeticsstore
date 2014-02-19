<?php
//this class is mapping to order and order_item table 

Class Order{
	private $order_id;
	private $customer_id;
	private $order_time;
	private $shipping_address;
	private $billing_address;
	private $email;
	private $zipcode;
	private $total_price;

	public static function create($order_time, $shipping_address, $billing_address, $email, $zipcode, $total_price) {
		$total_price_converted = number_format($total_price, 2, ".", "");
		
		$mysqli = new mysqli("classroom.cs.unc.edu", "fanl", "liuliushumeng", "fanldb");
		$result = $mysqli->query("insert into `ORDER` values (0, 1, " .
			     "'" . $mysqli->real_escape_string($order_time) . "', " .
			     "'" . $mysqli->real_escape_string($shipping_address) . "', " .
			     "'" . $mysqli->real_escape_string($billing_address) . "', " .
			     "'" . $mysqli->real_escape_string($email) . "', " .
			     "'" . $mysqli->real_escape_string($zipcode) . "', " .
			     "'" . $total_price_converted . "')" 
			     );

         

		if ($result) {
            $order_id = $mysqli->insert_id;
            return new Order($order_id, 1, $order_time, $shipping_address, $billing_address, $email, $zipcode, $total_price);
           }
        return null;

	}
	public static function findByID($order_id) {
    $mysqli = new mysqli("classroom.cs.unc.edu", "fanl", "liuliushumeng", "fanldb");

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
    $mysqli = new mysqli("classroom.cs.unc.edu", "fanl", "liuliushumeng", "fanldb");

    $result = $mysqli->query("select `order_id` from `ORDER`");
    $id_array = array();

    if ($result) {
      while ($next_row = $result->fetch_array()) {
	$id_array[] = intval($next_row['order_id']);
      }
    }
    return $id_array;
  }  



	private function __construct($order_id, $customer_id, $order_time, $shipping_address, $billing_address, $email, $zipcode, $total_price){
		$this->order_id = $order_id;
		$this->customer_id = $customer_id;
		$this->order_time = $order_time;
		$this->shipping_address = $shipping_address;
		$this->billing_address = $billing_address;
		$this->email = $email;
		$this->zipcode = $zipcode;
		$this->total_price = $total_price;
	}

	public function getOrderID(){
		return $this->order_id;
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

Class OrderItem{
	private $order_id;
	private $item_id;
	private $quantity;

	public static function create($order_id, $item_id, $quantity){
		$mysqli = new mysqli ("classroom.cs.unc.edu", "fanl", "liuliushumeng", "fanldb");
		$result = $mysqli->query("insert into `ORDER_ITEM` values ("
			      . intval($order_id) . ", " . intval($item_id) . ", " . intval($quantity) . ") ");
		if ($result) {
			return new OrderItem($order_id, $item_id, $quantity);
		}
		return null;
	}

	private function __construct($order_id, $item_id, $quantity){
		$this->order_id = $order_id;
		$this->item_id = $item_id;
		$this->quantity = $quantity;
	}


}