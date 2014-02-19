<?php
//this class it mapping to Inventory table 

class Item
{
	private $id;
	private $name;
	private $category;
	private $price;
	private $stock;
	private $description;
	private $image;

	public static function create ($id, $name, $category, $price, $stock, $description, $image){
		//this is used for create a new row in inventory table

	}

	public static function findByCategoryID ($category){
		$mysqli = new mysqli ("classroom.cs.unc.edu", "fanl", "liuliushumeng", "fanldb");


		$result = $mysqli->query("select * from INVENTORY where category = " . $category);

		$id_array = array();

		if ($result){
			while ($next_row = $result -> fetch_array()){
				$id_array[] = intval($next_row['item_id']);
			}
		}
		return $id_array;
	}

	public static function findByID ($id) {
		$mysqli = new mysqli("classroom.cs.unc.edu", "fanl", "liuliushumeng", "fanldb");

		$result = $mysqli->query("select * from INVENTORY where item_id =" .$id);
		if ($result){
			if($result->num_rows== 0){
				return null;
			}

			$item_info = $result->fetch_array();

			return new Item(intval($item_info['item_id']),
				            $item_info['item_name'],
				            intval($item_info['category']),
				            number_format($item_info['price'], 2, ".", ""),
				            intval($item_info['stock']),
				            $item_info['description'],
				            $item_info['image']
				            );
		}
	}

	public static function updateQuantityByID ($item_id, $quantityLess){
		$mysqli = new mysqli("classroom.cs.unc.edu", "fanl", "liuliushumeng", "fanldb");

        $resultQuantity = $mysqli->query("select stock from `INVENTORY` where item_id =" .$item_id);
        if ($resultQuantity){
        	while($next_row = $resultQuantity->fetch_array()){
        		$stock_array[] = intval($next_row['stock']);
        	}
        	
        	$item_new_quantity = $stock_array[0] - $quantityLess;
        	$resultUpdate = $mysqli->query("update `INVENTORY` set stock = ". $item_new_quantity. " where item_id= ". $item_id);
            if ($resultUpdate){
            	return true;
            }
        }
        return false;

	}
    

	private function __construct($id, $name, $category, $price, $stock, $description, $image){
		$this->id = $id;
		$this->name = $name;
		$this->category = $category;
		$this->price = $price;
		$this->stock = $stock;
		$this->description = $description;
		$this->image = $image;
	}

	public function getID(){
		return $this->id;
	}

	public function getName(){
	    return $this->name;
	}

	public function getCategory(){
		return $this->category;
	}

	public function getPrice(){
		return $this->price;
	}

	public function getStock(){
		return $this->stock;
	}

	public function getDescription(){
		return $this->description;
	}

	public function getImage(){
		return $this->image;
	}

	public function getJSON(){
		$json_obj = array('id' => $this ->id,
			'name' => $this->name,
			'category' => $this->category,
			'price'=>$this->price,
			'stock'=>$this->stock,
			'description'=> $this->description,
			'image' => $this ->image);
		return json_encode($json_obj);
	}

	


}