<?php
require('ormItem.php');

$path_components = explode('/', $_SERVER['PATH_INFO']);

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
	if ((count($path_components) >= 2) &&
      ($path_components[1] != "")) {

      	$item_id = intval($path_components[1]);
        
        $item = Item::findByID($item_id);
        
        if ($item == null) {
          // Todo not found.
          header("HTTP/1.0 404 Not Found");
          print("item id: " . $item_id . " not found.");
          exit();
        }
        //delete methods put here 
         
         //generate JSON encoding as response    
         else{
          header("Content-type: application/json");
         print($item->getJSON());
         exit();
       }




	}
} else if ($_SERVER['REQUEST_METHOD'] == "POST"){
	//Liuliu wrote this part 
}