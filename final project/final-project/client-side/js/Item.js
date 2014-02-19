var item = function (item_json){
	//constructor function
	this.item_id = item_json.id;
	this.item_name = item_json.name;
	this.category = item_json.category;
	this.price = item_json.price;
	this.stock = item_json.stock;
	this.description = item_json.description;
	this.image = item_json.image;
}

item.prototype.makeItemList = function(){
	//each item presentation in the product list page
	var iList = $("<li></li>");
	iList.addClass('box');

    //product image
	var image = $('<img>');
	image.attr('src', this.image);
	image.attr('alt', 'img for' + this.item_name);
	image.height(150);
	image.width(150);
	iList.append(image);

    //product name
	var title = $('<h3></h3>');
	title.html(this.item_name);
	iList.append(title);
    
    //product price
    var price = $('<span></span>');
    price.addClass('price');
    price.html(this.price);
    iList.append(price);


    //shop button
    iList.append($("<input type=submit class='green button'>").val("Shop now"));
    
    iList.data('item', this);
    return iList;
}


item.prototype.makeDetailedItem = function(){
	var itemDiv = $("<div></div>");
	itemDiv.addClass("complete-item-description");
    
    //product name 
	var productNameDiv = $("<div></div>");
	productNameDiv.addClass("product-name");
	var name = $('<h4></h4>');
	name.append("<span></span>").html(this.item_name);
	productNameDiv.append(name);
	itemDiv.append(productNameDiv);
    
    //product image
	var productImageDiv = $("<div></div>");
	productImageDiv.addClass("product-image");
	var image = $("<img>");
	image.attr("src", this.image);
	image.attr('alt', 'img for' + this.item_name);
	image.height(250);
	image.width(250);
	productImageDiv.append(image);
	itemDiv.append(productImageDiv);

    
	var productChoiceDiv = $("<div></div>");
	productChoiceDiv.addClass("product-info");
	var productList = $("<ul></ul>");

	//product price
	productList.append("<li>Price: "+ this.price + "</li>");

	//show the remaining stock
	productList.append("<li>" +this.stock + " items are available. </li>");
	
	//append quantity label 

    var qtyList = $("<li></li>");
	var label = $("<label>").text('Qty:');
	var input = $('<input type="text" id="quantity">');
	input.appendTo(label);
	qtyList.append(label);
	productList.append(qtyList);

    productChoiceDiv.append(productList);
    itemDiv.append(productChoiceDiv);

    //add to cart button
    var productButtonDiv = $("<div></div>");
    productButtonDiv.attr("id", "product-button");
    productButtonDiv.append("<img src='images/green-add-to-cart.png'>");
    productChoiceDiv.append(productButtonDiv);

    //go back to product list interface
    var back = $("<input class='green' type=submit>").val("Return back to List");
    back.attr("id", "goback");
    productChoiceDiv.append(back);
    

    //product description
    var productDescriptionDiv = $("<div></div>");
    productDescriptionDiv.addClass("product-description");
    var descriptionTitle = $('<h4>Description</h4>');
    var descriptionContent = $('<p></p>').html(this.description);
    productDescriptionDiv.append(descriptionTitle);
    productDescriptionDiv.append(descriptionContent);
    itemDiv.append(productDescriptionDiv);

    itemDiv.data("item", this);
    itemDiv.data("item-id", this.item_id);

    return itemDiv;


}