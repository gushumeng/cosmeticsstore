var url_base = "http://wwwp.cs.unc.edu/Courses/comp426-f13/shumengg/final-project/server-side";
var client_url_base = "http://wwwp.cs.unc.edu/Courses/comp426-f13/shumengg/final-project/client-side";
$(document).ready(function(){
	
    if(window.location.href == "http://wwwp.cs.unc.edu/Courses/comp426-f13/shumengg/final-project/client-side/face-list.html"){
	    category_id = 1;
	    path = "/face-list.html";

    }
    else if (window.location.href == "http://wwwp.cs.unc.edu/Courses/comp426-f13/shumengg/final-project/client-side/eyes-list.html"){
    	category_id = 2;
    	path = "/eyes-list.html";
    }
    else if (window.location.href == "http://wwwp.cs.unc.edu/Courses/comp426-f13/shumengg/final-project/client-side/lips-list.html"){
    	category_id = 3;
    	path = "/lips-list.html";

    }

	$.ajax(url_base + "/item-category.php/" + category_id,
		   {type: "GET",
		    dataType: "json",
		    success: function (item_ids, status, jqXHR) {
		    	for (var i = 0; i < item_ids.length; i++) {
		    		load_item_div(item_ids[i]);
		    	}
		    }

		   })	


	//when submit "shop now", it reloads to the item's detailed description. 
	$('#items').on("click",
		            ".box",
		            null,
		           function(e){
		           	var t = $(this).data('item');
		           	$("#main").empty();
		           	$("#main").append(t.makeDetailedItem());
		           });

    //in the item detail page, then click goback button, it reloads
    //the item list interface
	$("#main").on("click",
		          "#goback",
		           null,
		             function(e){
		             	e.preventDefault();
		             	window.location.assign(client_url_base + path);
                    });

	//when clicking the "add to cart" button
	$("#main").on("click",
		          "#product-button",
		          null,
		          function(e){
		                    	e.preventDefault();
		                    	var itemDiv = $(this).parent().parent();
		                    	var id = itemDiv.data("item-id");
		                    	var name = itemDiv.data("item").item_name;
		                    	var price = itemDiv.data("item").price;
		                    	var quantity = parseInt($("#quantity").val());
		                    	if (quantity > parseInt(itemDiv.data("item").stock)){
		                    		alert("the quantity should not be more than the available stock, please change the quantity");
		                    	}else if (quantity == ""){
		                    		alert("you must enter a quantity");
		                    	}
		                    	else {
		                    		$.ajax(url_base + "/cart.php",
		                    		{type:"POST",
		                    		      dataType: "json",
		                    		      data: {item_id: id, name: name, price: price, quantity: quantity},
		                    		      success: function(cart_json, status, jqXHR) {
		                    		      	
					                         $("#main").empty();
					                         $("#main").append(addCartSucceed);					  
					                      },
					                       error: function(jqXHR, status, error) {
					                          alert(jqXHR.responseText);
		                    	        	}
		                    	        });            			               
		                    			                    			                    		
			                 	}
			                 });
    
    //after the items have been added to the cart, and the user wants to continue shopping
    $("#main").on("click",
    	           "#cart_goback",
    	           null,
    	           function(e){
    	                 	e.preventDefault();
    	                 	window.location.assign(client_url_base + path);
    	                 });

    //after the items have been added to the cart, and the user wants to view cart and checkout
    $("#main").on("click",
    	          "#cart_checkout",
    	          null,
    	          function(e){
    	                    	e.preventDefault();
    	                    	window.location.assign("http://wwwp.cs.unc.edu/Courses/comp426-f13/shumengg/final-project/client-side/check-out.html");
    	                    	/*var qtyList = $("<li></li>");
	var label = $("<label>").text('Qty:');
	var input = $('<input type="text" id="quantity">');
	input.appendTo(label);
	qtyList.append(label);
	productList.append(qtyList);*/
    	                    })

	});

var load_item_div = function (id) {
	$.ajax(url_base + "/item.php/" +id,
		{type: "GET",
		dataType: "json",
	    success: function (item_json, status, jqXHR){
	    	var t = new item(item_json);
	    	$('#lists').append(t.makeItemList());
	    }
	});
};
//load the interface that indicates the item has been successfully put into the cart
var addCartSucceed = function(){
	var cartSucceed = $("<div></div>");
	cartSucceed.append("<p>The items have been added to your cart</p>");
	cartSucceed.append($("<input type=submit id ='cart_goback'>").val("Continue Shopping"));
	cartSucceed.append($("<input type=submit id='cart_checkout'>").val("View Cart and Check out"));
    return cartSucceed;
};
