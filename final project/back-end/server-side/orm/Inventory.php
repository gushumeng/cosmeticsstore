<?php

define("DB_HOST", "classroom.cs.unc.edu"); // classroom.cs.unc.edu
define("DB_USER", "fanl"); // fanl
define("DB_PASSWORD", "liuliushumeng"); // liuliushumeng
define("DB_DB", "fanldb");

class Inventory
{
  private $item_id;
  private $item_name;
  private $category;
  private $price;
  private $stock;
  private $description;
  private $image;

  public static function create($item_name, $category, $price, $stock, $description, $image) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);

    $result = $mysqli->query("insert into `INVENTORY` values (0, " .
			     "'" . $mysqli->real_escape_string($item_name) . "', " .
			     "'" . $mysqli->real_escape_string($category) . "', " .
				 "'" . $mysqli->real_escape_string($price) . "', " .
			     "'" . $mysqli->real_escape_string($stock) . "', " .
			     "'" . $mysqli->real_escape_string($description) . "', " .
			     "'" . $mysqli->real_escape_string($image) ."')");
    
    if ($result) {
      $item_id = $mysqli->insert_id;
      return new Inventory($item_id, $item_name, $category, $price, $stock, $description, $image);
    }
    return null;
  }

  public static function findByID($item_id) {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);

    $result = $mysqli->query("select * from `INVENTORY` where `item_id` = " . $item_id);
    if ($result) {
      if ($result->num_rows == 0) {
	return null;
      }

      $inventory_info = $result->fetch_array();

      return new Inventory(intval($inventory_info['item_id']),
		      $inventory_info['item_name'],
			  $inventory_info['category'],
		      $inventory_info['price'],
		      $inventory_info['stock'],
		      $inventory_info['description'],
		      $inventory_info['image']);
    }
    return null;
  }

  public static function getAllIDs() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);

    $result = $mysqli->query("select `item_id` from `INVENTORY`");
    $id_array = array();

    if ($result) {
      while ($next_row = $result->fetch_array()) {
	$id_array[] = intval($next_row['item_id']);
      }
    }
    return $id_array;
  }

  private function __construct($item_id, $item_name, $category, $price, $stock, $description, $image) {
    $this->item_id = $item_id;
    $this->item_name = $item_name;
	$this->category = $category;
    $this->price = $price;
    $this->stock = $stock;
    $this->description = $description;
    $this->image = $image;
  }

  public function getItemID() {
    return $this->item_id;
  }

  public function getItemName() {
    return $this->item_name;
  }

  public function getCategory() {
    return $this->category;
  }

  public function getPrice() {
    return $this->price;
  }

  public function getStock() {
    return $this->stock;
  }

  public function getDescription() {
    return $this->description;
  }

  public function getImage() {
    return $this->image;
  }

  public function setItemName($item_name) {
    $this->item_name = $item_name;
    return $this->update();
  }
  
  public function setCategory($category) {
    $this->category = $category;
    return $this->update();
  }

  public function setPrice($price) {
    $this->price = $price;
    return $this->update();
  }

  public function setStock($stock) {
    $this->stock = $stock;
    return $this->update();
  }

  public function setDescription($description) {
    $this->description = $description;
    return $this->update();
  }

  public function setImage($image) {
    $this->image = $image;
    return $this->update();
  }

  private function update() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);

    $result = $mysqli->query("update `INVENTORY` set " .
			     "item_name=" .
			     "'" . $mysqli->real_escape_string($this->item_name) . "', " .
				 "category=" .
			     "'" . $mysqli->real_escape_string($this->category) . "', " .
			     "price=" .
			     "'" . $mysqli->real_escape_string($this->price) . "', " .
			     "stock=" .
			     "'" . $mysqli->real_escape_string($this->stock) . "', " .
                 "description=" .
			     "'" . $mysqli->real_escape_string($this->description) . "', " .
				 "image=" .
			     "'" . $mysqli->real_escape_string($this->image) .
			     "' where `item_id`=" . $this->item_id);

    return $result;
  }

  public function delete() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DB);
    $mysqli->query("delete from `INVENTORY` where `item_id` = " . $this->item_id);
  }

  public function getJSON() {
    $json_obj = array('item_id' => $this->item_id,
		      'item_name' => $this->item_name,
			  'category' => $this->category,
		      'price' => $this->price,
		      'stock' => $this->stock,
		      'description' => $this->description,
		      'image' => $this->image);
    return json_encode($json_obj);
  }
}