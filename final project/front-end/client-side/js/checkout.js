var url_base = "http://wwwp.cs.unc.edu/Courses/comp426-f13/shumengg/final-project/server-side";
$(document).ready(function(){

    $.ajax(url_base + "/cart.php",
          {type: "GET",
           dataType: "json",
           success: function(cart_json, status, jqXHR){
            if(cart_json){
           	var cartTable = $("<table></table>");
           	cartTable.attr("id", "cartTable");
           	var cartHeader = $("<tr></tr>");
           	cartHeader.append("<th>item name</th>");
           	cartHeader.append("<th>quantity</th>");
           	cartHeader.append("<th>unit price</th>")
           	cartHeader.append("<th>total price</th>");
         
           	cartTable.append(cartHeader);

           	var totalPrice = 0;
            var cart_array = [];
            
           	for (var i = 0; i < cart_json.length; i++){
           		cartTable.append(makeCartRow(cart_json[i]));
           		cart_array.push(cart_json[i]);
           		totalPrice = parseFloat(parseFloat(totalPrice) + parseFloat(cart_json[i]["quantity"] * cart_json[i]["price"])).toFixed(2);
           	}

           	//add a total price row 
           	


           	
             var cartTotalPriceRow = $("<tr></tr>");
             cartTotalPriceRow.append("<td>Total</td>");
             cartTotalPriceRow.append("<td></td>");
             cartTotalPriceRow.append("<td></td>");
             cartTotalPriceRow.append("<td>"+totalPrice+"</td>");
             cartTable.append(cartTotalPriceRow);

           	$("#cart-list").append(cartTable); 
           	   
           	
           	$("#customer-info").data("cart", cart_array); 
           	$("#customer-info").data("totalPrice", totalPrice);  
            }
            else{
              $("#cart-list").append("<p>Your cart is empty</p>").css({
                  "color": "green",
                  "font-weight": "bolder"
              });
              $("#check").prop("disabled",true);
            }     	

           },
           error: function(jqXHR, status, error) {
			    alert(jqXHR.responseText);
		    }
       });
       

       $("#checkout").click(function(e){
       	                      	e.preventDefault();
       	                      	var cart_info = $(this).parent();
       	                      	var cart_array = cart_info.data("cart");
                        
       	                      	var total_price = cart_info.data("totalPrice");
       	                      	var shipping_address = $("#shipping_address").val();
       	                      	var billing_address = $("#billing_address").val();
       	                      	var zipcode = $("#zipcode").val();
       	                      	var email = $("#email").val();
                                if (total_price==""||shipping_address==""||billing_address==""||zipcode==""||email==""){
                                  alert("all information shouldn't be empty");
                                  return;
                                }
       	                      	$.ajax(url_base + "/order.php",
       	                      	{type:"POST",
       	                      	 dataType: "json",
       	                      	 data: {cart_item: cart_array, shipping_address: shipping_address, billing_address:billing_address, 
       	                      	 	    email: email, zipcode: zipcode, totalPrice: total_price},
       	                      	 success: function(json_ok, status, jqXHR){
       	                      	 	$("#main").empty();
       	                      	 	$("#main").append(loadSuccessPage());
       	                      	 },
       	                      	 error: function(jqXHR, status, error) {

					                          alert(jqXHR.responseText);
		                    	        	} 
       	                      	});       	                 
       	                      }
       	                 );
        $("#backtoshop").click(function(e){
                               e.preventDefault();
                               window.location.assign("http://wwwp.cs.unc.edu/Courses/comp426-f13/shumengg/final-project/client-side/index.html");
        })
        
        $("#main").on("click",
        	          "#checkout_goback",
        	          null,
        	          function(e){
        	          	e.preventDefault();
		             	window.location.assign("http://wwwp.cs.unc.edu/Courses/comp426-f13/shumengg/final-project/client-side/index.html");
        	          }
             
        	);
        
        //check out history
        $("#main").on("click",
        	          "#checkout_history",
                    null,
                    function(e){
                      e.preventDefault();
                      $("#main").empty();
                       $.ajax(url_base + "/order.php",
                                {type: "GET",
                                 dataType: "json",
                                 success: function(order_ids, status, jqXHR) {
                                   var orderTable = $("<table></table>");
                                   orderTable.attr("id", "orderTable");
                                   var orderHeader = $("<tr></tr>");
                                   orderHeader.append("<th>order time</th>");
                                   orderHeader.append("<th>shipping address</th>");
                                   orderHeader.append("<th>billing address</th>")
                                   orderHeader.append("<th>email</th>");
                                   orderHeader.append("<th>zip code</th>");
                                   orderHeader.append("<th>total price</th>");
         
                                   orderTable.append(orderHeader);
                                   for (var i=0; i<order_ids.length; i++) {
                                         load_order_item(order_ids[i]);
                                   }
                                   $("#main").append(orderTable);
                                   var continue_button = $("<input type=submit>").val("Continue Shopping");
                                   continue_button.click(function(e){
                                    window.location.assign("http://wwwp.cs.unc.edu/Courses/comp426-f13/shumengg/final-project/client-side/index.html");

                                   });
                                   $("#main").append(continue_button);
                                   
                         }
                        });

                      
                    })


       
});

var makeCartRow = function (itemArray){
	var name = itemArray["name"];
	var quantity = itemArray["quantity"];
	var price = itemArray["price"];
	var totalPrice = parseFloat(price * quantity).toFixed(2);
	var itemCartRow = $("<tr></tr>");
	itemCartRow.append("<td>" + name + "</td>");
	itemCartRow.append("<td>" + quantity + "</td>");
	itemCartRow.append("<td>" + price + "</td>");
	itemCartRow.append("<td>" + totalPrice + "</td>");
	
	return itemCartRow;
}

var loadSuccessPage = function(){
	var checkOutSucceed = $("<div></div>");
	checkOutSucceed.append("<p>Thank you for placing the order!</p>");
	checkOutSucceed.append($("<input type=submit id ='checkout_goback'>").val("Continue Shopping"));
	checkOutSucceed.append($("<input type=submit id='checkout_history'>").val("View Order History"));
    return checkOutSucceed;
}


var Order = function(order_json) {
    this.order_id = order_json.order_id;
    this.customer_id = order_json.customer_id;
    this.order_time = order_json.order_time;
    this.shipping_address = order_json.shipping_address;
    this.billing_address = order_json.billing_address;
    this.email = order_json.email;
    this.zipcode = order_json.zipcode;
    this.total_price = order_json.total_price;
};

Order.prototype.makeCompactOrderTable = function() {
    var ctable = $("<tr></tr>");
    ctable.addClass("order");

    var category_td = $("<td></td>");
    category_td.addClass('order_time');
    category_td.html(this.order_time);
    ctable.append(category_td);

    var price_td = $("<td></td>");
    price_td.addClass('shipping_address');
    price_td.html(this.shipping_address);
    ctable.append(price_td);

    var stock_td = $("<td></td>");
    stock_td.addClass('billing_address');
    stock_td.html(this.billing_address);
    ctable.append(stock_td);

    var description_td = $("<td></td>");
    description_td.addClass('email');
    description_td.html(this.email);
    ctable.append(description_td);

    var image_td = $("<td></td>");
    image_td.addClass('zipcode');
    image_td.html(this.zipcode);
    ctable.append(image_td);

    var price_td = $("<td></td>");
    price_td.addClass('total_price');
    price_td.html(this.total_price);
    ctable.append(price_td);

    

    ctable.data('order', this);

    return ctable;
};

var load_order_item = function (order_id) {
    $.ajax(url_base + "/order.php/" + order_id,
    {type: "GET",
     dataType: "json",
     success: function(order_json, status, jqXHR) {
        var t = new Order(order_json);
        
        $("#orderTable").append(t.makeCompactOrderTable());
        
        }
    });
}