var Inventory = function(inventory_json) {
    this.item_id = inventory_json.item_id;
    this.item_name = inventory_json.item_name;
	this.category = inventory_json.category;
    this.price = inventory_json.price;
    this.stock = inventory_json.stock;
    this.description = inventory_json.description;
    this.image = inventory_json.image;
};

Inventory.prototype.makeCompactInventoryTable = function() {
    var ctable = $("<tr></tr>");
	ctable.addClass("inventory");
	
	var id_td = $("<td></td>");
    id_td.addClass('item_id');
    id_td.html(this.item_id);
    ctable.append(id_td);

    var name_td = $("<td></td>");
    name_td.addClass('item_name');
    name_td.html(this.item_name);
    ctable.append(name_td);
	
    var category_td = $("<td></td>");
    category_td.addClass('category');
    category_td.html(this.category);
    ctable.append(category_td); 
	
	var price_td = $("<td></td>");
    price_td.addClass('price');
    price_td.html(this.price);
    ctable.append(price_td);
	
	var stock_td = $("<td></td>");
    stock_td.addClass('stock');
    stock_td.html(this.stock);
    ctable.append(stock_td);
	
	var description_td = $("<td></td>");
    description_td.addClass('description');
    description_td.html(this.description);
    ctable.append(description_td);
	
	var image_td = $("<td></td>");
    image_td.addClass('image');
    image_td.html(this.image);
    ctable.append(image_td);
	
	var delete_td = $("<td><button type='submit' class='delete' item_id='"+this.item_id+"'>delete</td>");
    delete_td.addClass('delete');
    ctable.append(delete_td);
	
	var de
	
    ctable.data('inventory', this);

    return ctable;
};

Inventory.prototype.makeEditDiv = function() {
    var ediv = $("<div></div>");

    var ediv_form = $("<form></form>");
    ediv_form.addClass('edit_form');
    
    ediv_form.append("Name: ");
    ediv_form.append($("<input type='text' name='item_name'>").val(this.item_name));
    ediv_form.append("<br>");
	
	ediv_form.append("Category: ");
    ediv_form.append($("<input type='text' name='category'>").val(this.category));
    ediv_form.append("<br>");
	
	ediv_form.append("Price: ");
    ediv_form.append($("<input type='text' name='price'>").val(this.price));
    ediv_form.append("<br>");

    ediv_form.append("Stock: ");
    ediv_form.append($("<input type='text' name='stock'>").val(this.stock));
    ediv_form.append("<br>");

    ediv_form.append("Description: ");
    ediv_form.append($("<textarea name='description'></textarea>").val(this.description));
    ediv_form.append("<br>");
	
	ediv_form.append("Image: ");
    ediv_form.append($("<input type='text' name='image'>").val(this.image));
    ediv_form.append("<br>");

    ediv_form.append("<button type='submit'>Save</button><button type='button' class='cancel'>Cancel</button>");
    ediv.append(ediv_form);
    
    ediv.data('inventory', this);
    return ediv;
}

Inventory.prototype.makeAddDiv = function() {
    var ediv = $("<div></div>");

    var ediv_form = $("<form></form>");
    ediv_form.addClass('add_form');

    ediv_form.append("Name: ");
    ediv_form.append($("<input type='text' name='item_name'>"));
    ediv_form.append("<br>");

    ediv_form.append("Category: ");
    ediv_form.append($("<input type='text' name='category'>"));
    ediv_form.append("<br>");

    ediv_form.append("Price: ");
    ediv_form.append($("<input type='text' name='price'>"));
    ediv_form.append("<br>");

    ediv_form.append("Stock: ");
    ediv_form.append($("<input type='text' name='stock'>"));
    ediv_form.append("<br>");

    ediv_form.append("Description: ");
    ediv_form.append($("<textarea name='description'></textarea>"));
    ediv_form.append("<br>");

    ediv_form.append("Image: ");
    ediv_form.append($("<input type='text' name='image'>"));
    ediv_form.append("<br>");

    ediv_form.append("<button type='submit'>Add</button><button type='button' class='cancel'>Cancel</button>");
    ediv.append(ediv_form);

    return ediv;
}

// order

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

    var id_td = $("<td></td>");
    id_td.addClass('order_id');
    id_td.html(this.order_id);
    ctable.append(id_td);

    var name_td = $("<td></td>");
    name_td.addClass('customer_id');
    name_td.html(this.customer_id);
    ctable.append(name_td);

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

    var delete_td = $("<td><button class='delete' item_id='"+this.order_id+"' type='submit'>delete</td>");
    delete_td.addClass('delete');
    ctable.append(delete_td);

    ctable.data('order', this);

    return ctable;
};

Order.prototype.makeEditDiv = function() {
    var ediv = $("<div></div>");

    var ediv_form = $("<form></form>");
    ediv_form.addClass('edit_form');

    ediv_form.append("Customer ID: ");
    ediv_form.append($("<input type='text' name='customer_id'>").val(this.customer_id));
    ediv_form.append("<br>");

    ediv_form.append("Order Time: ");
    ediv_form.append($("<input type='text' name='order_time'>").val(this.order_time));
    ediv_form.append("<br>");

    ediv_form.append("Shipping Address: ");
    ediv_form.append($("<input type='text' name='shipping_address'>").val(this.shipping_address));
    ediv_form.append("<br>");

    ediv_form.append("Billing Address: ");
    ediv_form.append($("<input type='text' name='billing_address'>").val(this.billing_address));
    ediv_form.append("<br>");

    ediv_form.append("Email: ");
    ediv_form.append($("<textarea name='email'></textarea>").val(this.email));
    ediv_form.append("<br>");

    ediv_form.append("Zipcode: ");
    ediv_form.append($("<input type='text' name='zipcode'>").val(this.zipcode));
    ediv_form.append("<br>");

    ediv_form.append("Total Price: ");
    ediv_form.append($("<input type='text' name='total_price'>").val(this.total_price));
    ediv_form.append("<br>");

    ediv_form.append("<button type='submit'>Save</button><button type='button' class='cancel'>Cancel</button>");
    ediv.append(ediv_form);

    ediv.data('order', this);
    return ediv;
}

Order.prototype.makeAddDiv = function() {
    var ediv = $("<div></div>");

    var ediv_form = $("<form></form>");
    ediv_form.addClass('add_form');

    ediv_form.append("Customer ID: ");
    ediv_form.append($("<input type='text' name='customer_id'>"))
    ediv_form.append("<br>");

    ediv_form.append("Order Time: ");
    ediv_form.append($("<input type='text' name='order_time'>"))
    ediv_form.append("<br>");

    ediv_form.append("Shipping Address: ");
    ediv_form.append($("<input type='text' name='shipping_address'>"))
    ediv_form.append("<br>");

    ediv_form.append("Billing Address: ");
    ediv_form.append($("<input type='text' name='billing_address'>"))
    ediv_form.append("<br>");

    ediv_form.append("Email: ");
    ediv_form.append($("<textarea name='email'></textarea>"))
    ediv_form.append("<br>");

    ediv_form.append("Zipcode: ");
    ediv_form.append($("<input type='text' name='zipcode'>"))
    ediv_form.append("<br>");

    ediv_form.append("Total Price: ");
    ediv_form.append($("<input type='text' name='total_price'>"))
    ediv_form.append("<br>");

    ediv_form.append("<button type='submit'>Add</button><button type='button' class='cancel'>Cancel</button>");
    ediv.append(ediv_form);

    return ediv;
}